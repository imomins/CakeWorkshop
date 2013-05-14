<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Users Controller
 *
 * @property User $User
 * @property Setting $Setting
 * @property Category $Category
 * @property Occupation $Occupation
 */
class UsersController extends AppController {

    var $actsAs = array('Containable');

    public $helpers = array('Frontend');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('register', 'login', 'logout', 'activate', 'reset', 'password');
    }

    // TODO: move to component
    protected function getRandomString() {
        return Security::hash(rand(100000, 100000000000000));
    }

    public function login() {
        if ($this->request->is('ajax')) {
            $this->autoRender  = false;
            $coursesByCategory = $this->User->CoursesTerm->findCoursesTermGroupedByCategoryWithBookingStateName(
                array('User' => array('id' => $this->getUserId()))
            );
            return json_encode(array('coursesByCategory' => $coursesByCategory));
        }
        $this->gotoHomeScreen();

        if ($this->request->is('post')) {

            if ($this->Auth->login()) {
                $this->gotoHomeScreen();
            }
            else {
                $this->Session->setFlash(__('Ungültiges Passwort oder Benutzername. Setzen Sie Ihr Passwort zurück falls nötig. <br />Beachten Sie, dass Ihr Konto auch deaktiviert worden sein könnte.'), 'flash_error');
            }
        }
        // Registration form data
        else {
            $genders     = $this->User->Gender->find('list');
            $departments = $this->User->Department->find('list');

            $this->loadModel('Category');
            $this->loadModel('Term');
            $this->loadModel('Occupation');
            $this->loadModel('Setting');

            $coursesByCategory = $this->Category->findCoursesGroupedByCategory();
            $occupations       = $this->Occupation->find('list');
            $settings          = $this->Setting->findHash();
            $title_for_layout  = __('Workshop Anmeldung');

            $this->set(compact('genders', 'departments', 'coursesByCategory', 'occupations', 'title_for_layout', 'settings'));
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function register() {
        if ($this->request->is('post')) {
            $this->User->create();

            // Randomly select a number for activation.
            // Don't forget CakePhp uses a salted hash, so it's secure enough.
            $hash = $this->getRandomString();

            // Let's filter we don't want post surprises
            $data = array(
                'User' => array(
                    'email'            => trim($this->request->data['User']['email']),
                    'password'         => trim($this->request->data['User']['password']),
                    'password_confirm' => trim($this->request->data['User']['password_confirm']),
                    'firstname'        => trim($this->request->data['User']['firstname']),
                    'lastname'         => trim($this->request->data['User']['lastname']),
                    'title'            => trim($this->request->data['User']['title']),
                    'gender_id'        => $this->request->data['User']['gender_id'],
                    'department_id'    => $this->request->data['User']['department_id'],
                    'occupation_id'    => $this->request->data['User']['occupation_id'],
                    'hrz'              => trim($this->request->data['User']['hrz']),
                    'phone'            => trim($this->request->data['User']['phone']),
                    'email_confirmed'  => 0,
                    'active'           => 0,
                    'group_name'       => 'attendee',
                    'hash'             => $hash
                )
            );

            if ($this->User->save($data)) {
                $this->sendActivationEmail($data['User']['email'], $hash);
                $this->Session->setFlash(__('Bitte schauen Sie zur Bestätigung Ihrer E-mail Adresse in Ihr Postfach.'), 'flash_success');
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }
            else {
                $this->Session->setFlash(json_encode($this->User->validationErrors), 'flash_error');
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }
        }
        else {
            throw new MethodNotAllowedException();
        }
    }

    public function email($email) {
        if ($this->request->is('post')) {
            $this->User->findByEmail($email);
        }
    }

    /**
     * Send a CakePhp email template to activate the users account.
     * We want to make sure that the users provide correct email and not
     * random accounts are opened.
     *
     * @param $to
     * @param $hash
     */
    private function sendActivationEmail($to, $hash) {
        $email = new CakeEmail('gmail');

        $email->template('register')
            ->emailFormat('html')
            ->viewVars(array('hash' => $hash))
            ->subject(__('Bitte aktivieren Sie Ihr Konto für Ihre Registrierung'))
            ->from('nicht-antworten@studiumdigitale.uni-frankfurt.de')
            ->to($to)
            ->send();
    }

    /**
     * Send a CakePhp email template to {@param $to} to confirm that the correct user
     * want to change his password.
     *
     * @param $to
     * @param $hash
     */
    private function sendPasswordResetMail($to, $hash) {
        $email = new CakeEmail('gmail');

        $email->template('password_reset')
            ->emailFormat('html')
            ->viewVars(array('hash' => $hash))
            ->subject(__('Passwortänderung-Anfrage auf dem Workshop-Portal'))
            ->from('nicht-antworten@studiumdigitale.uni-frankfurt.de')
            ->to($to)
            ->send();
    }

    public function activate($hash) {
        try {
            if ($this->User->activate($hash)) {
                $this->Session->setFlash(__('Bitte melden Sie sich an'), 'flash_info');
            }
        }
        catch (Exception $e) {
            $this->Session->setFlash($e->getMessage());
            $this->redirect(array('controller' => 'users', 'action' => 'register'));
        }
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }

    public function index() {
    }

    public function admin_index() {
        $query = (isset($this->request->data['query'])) ? $this->request->data['query'] : '';

        $this->paginate = array(
            'fields'     => array(
                'User.id',
                'User.group_name',
                'User.email',
                'User.title',
                'User.firstname',
                'User.lastname',
                'Group.name'
            ),
            'contain'    => array(
                'Group'  => array('fields' => array('name', 'display')),
                'Gender' => array('fields' => array('name')),
            ),
            'conditions' => array(
                'OR' => array(
                    "User.firstname LIKE" => '%' . trim($query) . '%',
                    "User.lastname LIKE"  => '%' . trim($query) . '%'
                )
            ),
            'order'      => array(
                'User.lastname'  => 'ASC',
                'User.firstname' => 'ASC',
            )
        );

        $this->set('query', $query);
        $this->set('users', $this->paginate());
    }

    public function search() {
        $this->autoRender = false;
        $auto_complete    = array();

        $users = $this->User->search($this->request['term']);

        foreach ($users as $id => $name) {
            array_push($auto_complete, array('value' => $id, 'label' => $name));
        }

        return json_encode($auto_complete);
    }

    public function view($id = null) {
        $user = $this->User->find('first',
            array(
                'conditions' => array('User.id' => $id),
                'fields'     => array(
                    'User.id',
                    'User.name',
                    'User.email',
                    'User.firstname',
                    'User.lastname',
                    'User.hrz',
                    'User.phone',
                    'User.created',
                    'User.group_name',
                    'User.active',
                    'Department.name',
                    'Gender.name',
                    'User.title',
                    'User.occupation_id',
                ),
                'contain'    => array(
                    'Gender', 'Department', 'Group',
                    'CoursesTerm' => array(
                        'fields' => array('term_id', 'course_id'),
                        'Course' => array('fields' => array('Course.id', 'Course.name')),
                        'Term'   => array('fields' => array('Term.id', 'Term.name')),
                    )
                ),
                'order'      => 'created DESC'
            )
        );
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Der Benutzer wurde nicht gefunden'));
        }

        $user             = $this->User->find('first',
            array(
                'conditions' => array('User.id' => $id),
                'fields'     => array(
                    'User.id',
                    'User.name',
                    'User.email',
                    'User.firstname',
                    'User.lastname',
                    'User.hrz',
                    'User.phone',
                    'User.created',
                    'User.group_name',
                    'User.active',
                    'Department.name',
                    'Gender.name',
                    'User.title',
                    'Group.display'
                ),
                'contain'    => array(
                    'Gender', 'Department', 'Group',
                    'Booking' => array(
                        'CoursesTerm' => array(
                            'fields' => array(),
                            'Course' => array('fields' => array('Course.name')),
                            'Term'   => array('fields' => array('Term.name')),
                        )
                    )
                ),
                'order'      => 'created DESC'
            )
        );
        $title_for_layout = $user['User']['name'];
        $this->set(compact('user', 'title_for_layout'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Der Benutzer wurde angelegt'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Es ist ein Fehler aufgetreten'), 'flash_error');
            }
        }
        $genders     = $this->User->Gender->find('list');
        $departments = $this->User->Department->find('list');
        $occupations = $this->User->Occupation->find('list');
        $groups      = $this->User->Group->find('list');

        $this->set(compact('genders', 'departments', 'groups', 'coursesTerms', 'occupations'));
    }

    /**
     * If an email address is posted to this method the "email_update"
     * field will be set to the new email address and a random hash
     * is assigned to the "hash" and send a confirmation email which
     * links to the "password" method which searches for this random hash.
     *
     * @throws NotFoundException
     * @throws InternalErrorException
     */
    public function reset() {
        $this->gotoHomeScreen();

        if ($this->request->is('post') && isset($this->request->data['User']['email'])) {

            // Search the email
            $user           = $this->User->findUserIdByEmail($this->request->data['User']['email']);
            $this->User->id = $user['User']['id'];

            if ($this->User->exists()) {
                $hash = $this->getRandomString();

                if ($this->User->save(array('User' => array('hash' => $hash)))) {
                    $this->sendPasswordResetMail(trim($this->request->data['User']['email']), $hash);

                    $this->Session->setFlash(__('Ihnen wurde eine Email zugesandt, bitte überprüfen Sie Ihr Postfach'), 'flash_success');
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }
                else {
                    throw new InternalErrorException(__('Ein internet Fehler ist aufgetreten'), 'flash_error');
                }
            }
            else {
                throw new NotFoundException(__('Keinen Benutzer gefunden'), 'flash_error');
            }
        }
    }

    /**
     * In case of a post request which provides an email address the "hash" field of the
     * users table will be searched for it and the provided email will be temporarily
     * stored in the field "email_update" until the user confirms it via an email.
     *
     * @param null $hash
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @throws InternalErrorException
     */
    public function password($hash = null) {
        if ($hash === null) {
            throw new MethodNotAllowedException(__('Fehlerhafter Zugriff'));
        }
        if ($this->request->is('post')) {

            $user           = $this->User->findUserIdByHash($this->request->data['User']['hash']);
            $this->User->id = $user['User']['id'];

            if ($this->User->exists()) {
                if (
                    $this->User->save(
                        array(
                            'User' => array(
                                'password'         => $this->request->data['User']['password'],
                                'password_confirm' => $this->request->data['User']['password_confirm'],
                                'hash'             => null
                            )
                        )
                    )
                ) {
                    $this->Session->setFlash(__('Ihr Passwort wurde geändert, bitte melden Sie sich an.'), 'flash_success');
                    $this->redirect('/users/login');
                }
            }
            else {
                throw new NotFoundException(__('Keinen Benutzer gefunden'));
            }

        }
        $this->set('hash', $hash);
    }

    public function details() {
        if ($this->request->is('post')) {
            $this->User->id = $this->getUserId();

            if ($this->User->exists()) {
                if ($this->User->save(
                    array('User' => array(
                        'gender_id'     => $this->request->data['User']['gender_id'],
                        'title'         => $this->request->data['User']['title'],
                        'firstname'     => $this->request->data['User']['firstname'],
                        'lastname'      => $this->request->data['User']['lastname'],
                        'department_id' => $this->request->data['User']['department_id'],
                        'occupation_id' => $this->request->data['User']['occupation_id'],
                        'hrz'           => $this->request->data['User']['hrz'],
                        'phone'         => $this->request->data['User']['phone'],
                    )
                    ))
                ) {
                    $this->Session->setFlash(__('Ihr Konto wurde aktualisiert'), 'flash_success');
                }
                else {
                    $this->Session->setFlash(__('Fehler beim speichern Ihres Kontos'), 'flash_error');
                }
            }
            $this->redirect('/users/edit');
        }
        else {
            throw new MethodNotAllowedException();
        }
    }

    public function account() {
        if ($this->request->is('post')) {

            if ($this->request->data['User']['password'] !== $this->request->data['User']['password_confirm']) {
                throw new Exception(__('Die Passwörter sind nicht identisch'));
            }

            $this->User->unbindModel(array(
                'belongsTo' => array('Group', 'Gender', 'Occupation', 'Department')
            ));

            if ($this->User->updateAll(
                array(
                    'email'    => "'" . trim($this->request->data['User']['email']) . "'",
                    'password' => "'" . AuthComponent::password($this->request->data['User']['password']) . "'"
                ),
                array('User.id =' => $this->getUserId())
            )
            ) {
                $this->Session->setFlash(__('Ihr Konto wurde aktualisiert'), 'flash_success');
                $this->redirect('/users/edit');
            }
            else {
                throw new Exception(__('Fehler beim speicher'));
            }
        }
        else {
            throw new MethodNotAllowedException();
        }
    }

    /*
     * Non admin users only edit their own profile.
     */
    public function edit() {
        $this->User->recursive = -1;
        $this->User->id        = $this->Auth->user('id');

        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'), 'flash_success');
                $this->redirect(array('action' => 'index'));
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash_error');
            }
        }
        else {
            $this->request->data = $this->User->read(null, $this->Auth->user('id'));
        }
        $genders     = $this->User->Gender->find('list');
        $departments = $this->User->Department->find('list');
        $occupations = $this->User->Occupation->find('list');

        $this->set(compact('genders', 'departments', 'coursesTerms', 'occupations'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Der Benutzer wurde nicht gefunden'), 'flash_error');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Die Daten wurden gespeichert'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash_error');
            }
        }
        else {
            $this->request->data = $this->User->read(null, $id);
        }
        $genders          = $this->User->Gender->find('list');
        $departments      = $this->User->Department->find('list');
        $groups           = $this->User->Group->find('list');
        $occupations      = $this->User->Occupation->find('list');
        $title_for_layout = $this->request->data['User']['name'];

        $this->set(compact('genders', 'departments', 'groups', 'coursesTerms', 'occupations', 'title_for_layout'));
    }

    /**
     * delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'), 'flash_error');
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'), 'flash_error');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_find() {
        $this->autoRender = false;

        return json_encode($this->User->find('all', array(
            'fields'     => array('id', 'name', 'email'),
            'limit'      => '10',
            'recursive'  => -1,
            'conditions' => array(
                "CONCAT(firstname, ' ', lastname, '(', email, ')') LIKE" => '%' . $this->request->data('name') . '%'
            )
        )));
    }

}
