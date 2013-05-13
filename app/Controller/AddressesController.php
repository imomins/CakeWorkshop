<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * addresses Controller
 *
 * @property Address $Address
 */
class AddressesController extends AppController {

    /**
     * @param null $id
     * @return string
     */
    public function admin_index($id = null) {
        // Returns list of users addresses
        if ($this->request->is('ajax')) {
            $this->autoRender = false;

            $addresses = $this->Address->query("
                SELECT * FROM  addresses Address
                    LEFT JOIN types Type ON (Address.type_name = Type.name)
                WHERE
                    Address.user_id = ?
                ", array($id));

            return json_encode($addresses);
        }
        else {
            $this->Address->recursive = 0;
            $this->set('addresses', $this->paginate());
        }
    }

    public function index() {
        $this->autoRender = false;

        $addresses = $this->Address->find(
            'all',
            array(
                'recursive'  => -1,
                'fields'     => array('id', 'type_name', 'institution', 'department', 'postbox', 'to_person', 'street', 'zip', 'location', 'name'),
                'conditions' => array('user_id' => $this->getUserId())
            )
        );
        return json_encode($addresses);
    }

    public function types() {
        $this->autoRender               = false;
        $this->Address->Type->recursive = -1;
        $types                          = $this->Address->Type->find('all');
        return json_encode($types);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id) {
        $sql = '
            SELECT User.id,User.firstname,User.lastname,Type.display,Address.* FROM addresses Address
                LEFT JOIN users User ON (Address.user_id = User.id)
                LEFT JOIN types Type ON (Address.type_name = Type.name)
            WHERE
                Address.id = ?
            LIMIT 1
        ';

        $sql_related_bookings = '
            SELECT Booking.id, Type.display, Course.name, Schedule.display, Term.name FROM bookings Booking
                LEFT JOIN addresses Address ON (Booking.address_id = Address.id)
                LEFT JOIN types Type ON (Address.type_name = Type.name)
                LEFT JOIN courses_terms CoursesTerm ON (Booking.courses_term_id = CoursesTerm.id)
                LEFT JOIN courses Course ON (CoursesTerm.course_id = Course.id)
                LEFT JOIN schedules Schedule ON (CoursesTerm.schedule_name = Schedule.name)
                LEFT JOIN terms Term ON (CoursesTerm.term_id = Term.id)
            WHERE
                Booking.address_id = ?
        ';

        $address = $this->Address->query($sql, array($id));
        $address = $address[0];

        $related_bookings = $this->Address->query($sql_related_bookings, array($id));

        if (empty($address)) {
            throw new NotFoundException(__('Ungültige Rechnung'));

        }
        $this->set(compact('address', 'related_bookings'));
    }

    public function view($id) {
        $this->autoRender = false;

        $addresses = $this->Address->find(
            'first',
            array(
                'recursive'  => -1,
                'fields'     => array('id', 'type_name', 'institution', 'department', 'postbox', 'to_person', 'street', 'zip', 'location', 'name'),
                'conditions' => array('user_id' => $this->getUserId(), 'id' => $id)
            )
        );
        if (sizeof($addresses) > 0) {
            return json_encode($addresses);
        }
        else {
            throw new NotFoundException(__('Rechnung nicht gefunden'));
        }
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Address->create();
            if ($this->Address->save($this->request->data)) {
                $this->Session->setFlash(__('Die Adresse wurde gespeichert'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Es ist ein Fehler aufgetreten'), 'flash_error');
            }
        }
        $types = $this->Address->Type->find('list');
        $users = $this->Address->User->find('list');
        $this->set(compact('types', 'users'));
    }

    public function add() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->autoRender = false;

        $this->Address->create();
        if ($this->Address->save(array(
            'Address' => array(
                'user_id'     => $this->getUserId(),
                'type_name'   => $this->request->data['type_name'],
                'institution' => $this->request->data['institution'],
                'department'  => $this->request->data['department'],
                'postbox'     => $this->request->data['postbox'],
                'to_person'   => $this->request->data['to_person'],
                'street'      => $this->request->data['street'],
                'zip'         => $this->request->data['zip'],
                'location'    => $this->request->data['location']
            )
        ))
        ) {
            return json_encode($this->Address->findById($this->Address->getLastInsertID()));
        }
        else {
            return json_encode(array('message' => __('Fehler beim Speichern')));
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Address->id = $id;
        if (!$this->Address->exists()) {
            throw new NotFoundException(__('Invalid Address'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Address->save($this->request->data)) {
                $this->Session->setFlash(__('Die Adresse wurde gespeichert'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Es ist ein Fehler aufgetreten'), 'flash_error');
            }
        }
        else {
            $this->request->data = $this->Address->read(null, $id);

            $related_courses_terms = $this->Address->query('
                SELECT Address.id,Booking.id,CoursesTerm.id,Schedule.display,Course.name,Category.name,Term.id,Term.name FROM addresses Address
                    LEFT OUTER JOIN bookings Booking ON (Address.id = Booking.address_id)
                    LEFT OUTER JOIN courses_terms CoursesTerm ON (Booking.courses_term_id = CoursesTerm.id)
                    LEFT OUTER JOIN courses Course ON (CoursesTerm.course_id = Course.id)
                    LEFT OUTER JOIN terms Term ON (CoursesTerm.term_id = Term.id)
                    LEFT OUTER JOIN categories Category ON (Course.category_id = Category.id)
                    LEFT OUTER JOIN schedules Schedule ON (CoursesTerm.schedule_name = Schedule.name)
                WHERE Address.id = ?
                    ORDER BY Term.id DESC,Course.name ASC
            ', array($id));

            $types = $this->Address->Type->find('list');
            $this->set(compact('types', 'related_courses_terms'));
        }
    }

    public function edit() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->autoRender = false;

        $this->Address->recursive = -1;
        if ($this->Address->updateAll(
            array(
                'Address.type_name'   => "'" . Sanitize::escape($this->request->data['type_name']) . "'",
                'Address.institution' => "'" . Sanitize::escape($this->request->data['institution']) . "'",
                'Address.department'  => "'" . Sanitize::escape($this->request->data['department']) . "'",
                'Address.postbox'     => "'" . Sanitize::escape($this->request->data['postbox']) . "'",
                'Address.to_person'   => "'" . Sanitize::escape($this->request->data['to_person']) . "'",
                'Address.street'      => "'" . Sanitize::escape($this->request->data['street']) . "'",
                'Address.zip'         => "'" . Sanitize::escape($this->request->data['zip']) . "'",
                'Address.location'    => "'" . Sanitize::escape($this->request->data['location']) . "'"
            ),
            array(
                'Address.user_id' => $this->getUserId(),
                'Address.id'      => intval($this->request->data['address_id'])
            )
        )
        ) {
            return json_encode($this->Address->findById($this->request->data['address_id']));
        }
        else {
            return json_encode(array('message' => __('Fehler beim Speichern')));
        }
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
        $this->Address->id = $id;
        if (!$this->Address->exists()) {
            throw new NotFoundException(__('Invalid Address'));
        }
        if ($this->Address->delete()) {
            $this->Session->setFlash(__('Address deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Address was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function delete() {
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        if (!$this->Address->deleteAll(
            array(
                'Address.id'      => $this->request->data['id'],
                'Address.user_id' => $this->getUserId()
            ),
            false
        )
        ) {
            throw new Exception(__('Die Rechnung konnte nicht gelöscht werden'));
        }
    }

}
