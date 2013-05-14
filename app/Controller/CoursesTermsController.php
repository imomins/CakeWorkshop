<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
/**
 * CoursesTerms Controller
 *
 * @property CoursesTerm $CoursesTerm
 * @property Setting $Setting
 */
class CoursesTermsController extends AppController {

    public $components = array('RequestHandler');

    public $helpers = array('Frontend');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('get');
    }

    /**
     * Used by login and bookings screen
     */
    public function get() {
        $coursesByCategory = $this->CoursesTerm->findCoursesTermGroupedByCategoryWithBookingStateName(
            array('Editable' => true, 'User' => array('id' => $this->getUserId()))
        );
        $this->set(compact('coursesByCategory'));
        $this->set('_serialize', array('coursesByCategory'));
    }

    /**
     * @param int $term_id
     */
    public function admin_index($term_id = null) {
        $this->request->data['term_id'] = $term_id;

        // Redirect to current term
        if ($term_id === null) {
            $this->loadModel('Setting');
            $term    = $this->Setting->findByKey('current_term');
            return $this->redirect('/admin/courses_terms/index/' . $term['Setting']['value']);
        }

        // TODO: array_push explodes for conditions, reason for ugly code below, check again
        $this->paginate = array(
            'order'      => array('id' => 'DESC'),
            'conditions' => array()
        );

        // Search condition
        if ($this->request->is('post')) {
            $this->paginate = array('conditions' => array('Course.name LIKE' => '%' . trim($this->request->data['query']) . '%'));
        }
        // Term condition
        if ($term_id !== null) {
            // Combine
            if (isset($this->request->data['query'])) {
                $this->paginate = array(
                    'conditions' => array(
                        'CoursesTerm.term_id' => $term_id,
                        'Course.name LIKE'    => '%' . Sanitize::escape(trim($this->request->data['query'])) . '%'
                    ),
                    'order'      => array('CoursesTerm.id DESC')
                );
            }
            else {
                $this->paginate = array('conditions' => array('CoursesTerm.term_id' => $term_id));
            }
        }

        $terms = $this->CoursesTerm->Term->find('list', array(
            'order' => 'Term.id DESC'
        ));

        $title_for_layout = __('Semester-Kurse');

        $this->set(compact('terms', 'title_for_layout'));
        $this->set('coursesTerms', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id) {
        $this->CoursesTerm->id = $id;
        if (!$this->CoursesTerm->exists()) {
            throw new NotFoundException(__('Invalid courses term'));
        }

        if ($this->request->is('ajax')) {
            // Request
            $bookings = $this->CoursesTerm->query("
                SELECT User.id, CONCAT(User.firstname, ' ', User.lastname) User_name, User.email, Booking.id,DATE_FORMAT(Booking.created, '%d.%m.%Y, %H:%i') Booking_created,DATE_FORMAT(Booking.unsubscribed_at, '%d.%m.%Y, %H:%i') Booking_unsubscribed_at,BookingState.name,BookingState.display FROM bookings Booking
                    LEFT OUTER JOIN users User ON (Booking.user_id = User.id)
                    LEFT OUTER JOIN booking_states BookingState ON (Booking.booking_state_name = BookingState.name)
                WHERE Booking.courses_term_id = ?
                    ORDER BY FIELD(BookingState.display,'unconfirmed','self_unsubscribed','admin_unsubscribed','confirmed'), User_name ASC
                ", array($id));

            $this->set('bookings', $bookings);
            $this->set('_serialize', array('bookings'));
            return;
        }

        // Don't need all for main data, rest is loaded via json
        $this->CoursesTerm->unbindModel(array(
            'hasMany'             => array('Booking'),
            'hasAndBelongsToMany' => array('User')
        ));
        $coursesTerm      = $this->CoursesTerm->read(null, $id);
        $title_for_layout = __('Übersicht - Kurs-Nr.: %s', $coursesTerm['CoursesTerm']['id']);

        $this->set(compact('coursesTerm', 'title_for_layout'));
    }

    public function admin_list($id, $type = 'landscape') {
        $coursesTerm = $this->CoursesTerm->query("
            SELECT CoursesTerm.id,Course.name,Term.name FROM courses_terms CoursesTerm
                LEFT OUTER JOIN courses Course ON (CoursesTerm.course_id = Course.id)
                LEFT OUTER JOIN terms Term ON (CoursesTerm.term_id = Term.id)
            WHERE
                CoursesTerm.id = ?
        ", array($id));
        $coursesTerm = $coursesTerm[0];

        $bookings = $this->CoursesTerm->query("
            SELECT User.title, User.firstname, User.lastname FROM bookings Booking
                LEFT OUTER JOIN users User ON (Booking.user_id = User.id)
            WHERE
                Booking.courses_term_id = ? AND Booking.booking_state_name = 'confirmed'
            ORDER BY
                User.lastname ASC
        ", array($id));

        $this->layout = $type;
        $this->set(compact('bookings', 'coursesTerm'));
    }

    public function admin_nameplates() {
    }

    public function admin_pdf($id = null, $filename = null) {
        $this->CoursesTerm->id = $id;
        if (!$this->CoursesTerm->exists()) {
            throw new NotFoundException(__('Invalid courses term'));
        }
        $this->set('coursesTerm', $this->CoursesTerm->read(null, $id));
        $this->set('filename', $filename);

        $this->layout = 'pdf';
        $this->render();
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->CoursesTerm->create();
            if ($this->CoursesTerm->save($this->request->data)) {
                $this->Session->setFlash(__('Der Semester-Kurs wurde angelegt'), 'flash_success');
                $this->redirect(array('action' => 'view', $this->CoursesTerm->getLastInsertID()));
            }
            else {
                $this->Session->setFlash(__('Der Kurs konnte nicht gespeichert werden'), 'flash_error');
            }
        }
        $schedules = $this->CoursesTerm->Schedule->find('list');
        $terms     = $this->CoursesTerm->Term->find('list');
        $courses   = $this->CoursesTerm->Course->find('list');
        $users     = $this->CoursesTerm->User->find('list');
        $this->set(compact('terms', 'courses', 'users', 'schedules'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->CoursesTerm->id = $id;
        if (!$this->CoursesTerm->exists()) {
            throw new NotFoundException(__('Invalid courses term'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->CoursesTerm->save($this->request->data)) {
                $this->Session->setFlash(__('Die Daten wurden gespeichert'), 'flash_success');
                $this->redirect(array('action' => 'view', $id));
            }
            else {
                $this->Session->setFlash(__('Fehler beim Speichern'), 'flash_error');
            }
        }
        else {
            $this->CoursesTerm->unbindModel(array(
                'hasAndBelongsToMany' => array('User'),
                'hasMany'             => array('Booking')
            ));
            $this->request->data = $this->CoursesTerm->read(array(
                'Course.name', 'CoursesTerm.location', 'CoursesTerm.schedule_name', 'Term.name', 'CoursesTerm.id', 'CoursesTerm.max'
            ), $id);
        }
        $terms     = $this->CoursesTerm->Term->find('list', array('order' => array('Term.name' => 'ASC')));
        $schedules = $this->CoursesTerm->Schedule->find('list', array('order' => array('Schedule.display' => 'ASC')));
        $courses   = $this->CoursesTerm->Course->find('list', array('order' => array('Course.name' => 'ASC')));
        $users     = $this->CoursesTerm->User->find('list');
        $this->set(compact('terms', 'courses', 'users', 'schedules'));
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
        $this->CoursesTerm->id = $id;
        if (!$this->CoursesTerm->exists()) {
            throw new NotFoundException(__('Invalid courses term'));
        }
        if ($this->CoursesTerm->delete()) {
            $this->Session->setFlash(__('Courses term deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Courses term was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function admin_find() {
        $this->autoRender = false;

        return json_encode($this->CoursesTerm->find('all', array(
            'fields'     => array('CoursesTerm.id', 'Term.name', 'Course.name'),
            'limit'      => '10',
            'conditions' => array(
                'OR' => array(
                    "Course.name LIKE" => '%' . $this->request->data('name') . '%',
                    "Term.name LIKE"   => '%' . $this->request->data('name') . '%'
                )
            ),
            'order'      => array('CoursesTerm.id DESC')
        )));
    }

}
