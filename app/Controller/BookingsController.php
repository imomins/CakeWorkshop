<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Bookings Controller
 *
 * @property Booking $Booking
 */
class BookingsController extends AppController {

    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();

        // Used on login page
        if ($this->request->is('ajax')) {
            $this->Auth->allow('index');
        }
    }

    /**
     * index method
     *
     * @param $termId
     * @return void
     */
    public function admin_index($termId = null) {
        if ($termId === null) {
            $termId = $this->Booking->query('SELECT id FROM terms ORDER BY id DESC LIMIT 1');
            $termId = $termId[0]['terms']['id'];
        }

        $query = isset($this->request->data['query']) ? $this->request->data['query'] : '';

        $this->paginate = array(
            'conditions' => array("CONCAT(firstname, ' ', lastname) LIKE" => '%' . trim($query) . '%'),
            'order'      => array('Booking.created' => 'DESC'),
            'contain'    => array(
                'User'        => array('fields' => array('name', 'id')),
                'CoursesTerm' => array(
                    'Course' => array('fields' => array('name')),
                    'Term'   => array('conditions' => array('Term.id' => $termId))
                )
            )
        );

        $title_for_layout = __('Neusten Anmeldungen');
        $bookings         = $this->paginate('Booking');
        $terms            = $this->Booking->CoursesTerm->Term->find('list');

        $this->set(compact('bookings', 'terms', 'title_for_layout'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Booking->id = $id;
        if (!$this->Booking->exists()) {
            throw new NotFoundException(__('Ungültiger Semester-Kurs'));
        }

        $sql = "
            SELECT Booking.id,Booking.notes,Booking.certificate,DATE_FORMAT(Booking.unsubscribed_at, '%d.%m.%Y, %H:%i') Booking_unsubscribed_at,DATE_FORMAT(Booking.created, '%d.%m.%Y, %H:%i') Booking_created,
                   Address.*,CoursesTerm.id,
                   Type.display,
                   BookingState.*,
                   User.id,User.firstname,User.lastname, User.notes,
                   AttendanceStatus.display,
                   Course.name,
                   Term.id,Term.name
            FROM bookings Booking
                LEFT JOIN users User ON (Booking.user_id = User.id)
                LEFT JOIN courses_terms CoursesTerm ON (Booking.courses_term_id = CoursesTerm.id)
                LEFT JOIN courses Course ON (CoursesTerm.course_id = Course.id)
                LEFT JOIN terms Term ON (CoursesTerm.term_id = Term.id)
                LEFT JOIN addresses Address ON (Booking.address_id = Address.id)
                LEFT JOIN booking_states BookingState ON (Booking.booking_state_name = BookingState.name)
                LEFT OUTER JOIN types Type ON (Address.type_name = Type.name)
                LEFT OUTER JOIN attendance_states AttendanceStatus ON (Booking.attendance_state_name = AttendanceStatus.name)
            WHERE
                Booking.id = ?
        ";

        $booking = $this->Booking->query($sql, array($id));

        // One row...
        $booking = $booking[0];

        // DATE_FORMAT removes the context, restore...
        $booking['Booking']['created']         = $booking['0']['Booking_created'];
        $booking['Booking']['unsubscribed_at'] = $booking['0']['Booking_unsubscribed_at'];

        $this->set(compact('booking'));
    }

    /**
     * 2. Cases possible:
     * 2.1. Booking exists and has status self_unsubscribed -> set self_subscribed
     * 2.2. Or is completely new -> create record
     * After that an email is sent to the user with details about the subscription.
     *
     * @return string
     * @throws MethodNotAllowedException
     * @throws Exception
     */
    public function add() {
        $this->autoRender = false;

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $ids = array(); // Retain courses for confirmation email
        foreach ($this->request->data['CoursesTerm'] as $id) {
            array_push($ids, intval($id));

            $data = array(
                'Booking.user_id'            => intval($this->getUserId()),
                'Booking.courses_term_id'    => $id,
                'Booking.address_id'         => $this->request->data['Address']['id'],
                'Booking.booking_state_name' => "'unconfirmed'",
                'Booking.certificate'        => false,
                'Booking.unsubscribed_at'    => null
            );

            $conditions = array(
                'Booking.user_id'                                                       => $this->getUserId(),
                'Booking.courses_term_id'                                               => $id,
                '(SELECT locked FROM courses_terms WHERE id = Booking.courses_term_id)' => 0 // Prevents injection for locked courses
            );

            // Check if exists then update...
            if ($this->Booking->hasAny($conditions)) {
                $status = $this->Booking->updateAll(
                    $data,
                    $conditions
                );
            }
            // ...otherwise insert
            else {
                // TODO: why is this crap not working, used SQL
                // No condition, we assume that if the user can choose a course then it's not locked
                //                $this->Booking->create();
                //     $status = $this->Booking->save($data);
                $sql = "INSERT INTO bookings (user_id,courses_term_id,address_id,booking_state_name) VALUES (?,?,?,'unconfirmed')";
                $this->Booking->query($sql, array($this->getUserId(), $id, $this->request->data['Address']['id']));
                $status = true;
            }

            if (!$status) {
                throw new Exception(__('Es ist ein Fehler aufgetreten: ') . json_encode($this->Booking->validationErrors));
            }
            else {
                $this->Booking->query('UPDATE courses_terms CoursesTerm SET CoursesTerm.attendees = CoursesTerm.attendees + 1 WHERE CoursesTerm.id = ?', array($id));
            }
        }

        $email = new CakeEmail('gmail');
        $email->template('preliminary_course_confirmation')
            ->viewVars(array('categories' => $this->Booking->findBookingsByIds($this->getUserId(), $ids)))
            ->subject(__('Übersicht Ihrer Anmeldung vom ' . date('d.m.Y, H:i') . ' Uhr'))
            ->from('nicht-antworten@test.com')
            ->emailFormat('html')
            ->to($this->Auth->user('email'))
            ->replyTo('nicht-antworten@test.com')
            ->send();

        return json_encode(array('message' => __('Die Kurse wurden gebucht'), 'id' => $this->Booking->id));
    }

    public function admin_status($booking_state_name, $id) {
        $this->autoRender = false;

        $this->Booking->id = $id;
        if (!$this->Booking->exists()) {
            throw new Exception(__('Die Buchung wurde nicht gefunden'));
        }

        if (!$this->Booking->saveField('booking_state_name', $booking_state_name)) {
            throw new Exception(__('Fehler beim Speichern: ') . $this->Booking->validationErrors['booking_state_name']);
        }
        else {
            // Attendee counter
            $booking = $this->Booking->find('first', array(
                'recursive'  => -1,
                'conditions' => array('Booking.id' => $id),
                'fields'     => array('Booking.courses_term_id')
            ));

            if ($booking_state_name !== 'confirmed') {
                $this->Booking->query('UPDATE courses_terms CoursesTerm SET CoursesTerm.attendees = CoursesTerm.attendees - 1 WHERE CoursesTerm.id = ?', array($booking['Booking']['courses_term_id']));
            }
            if ($booking_state_name === 'confirmed') {
                $this->Booking->query('UPDATE courses_terms CoursesTerm SET CoursesTerm.attendees = CoursesTerm.attendees + 1 WHERE CoursesTerm.id = ?', array($booking['Booking']['courses_term_id']));
            }
        }
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Booking->create();

            if ($this->request->data['Booking']['attendance_state_name'] === '') {
                $this->request->data['Booking']['attendance_state_name'] = null;
            }

            if ($this->Booking->save($this->request->data)) {
                $this->Session->setFlash(__('Die Anmeldung wurde gespeichert'), 'flash_success');
                $this->redirect(array('action' => 'view', $this->Booking->getLastInsertID()));
            }
            else {
                $this->Session->setFlash(__('Es ist ein Fehler aufgetreten'), 'flash_error');
            }
        }

        $attendance_state = $this->Booking->AttendanceState->find('list');
        $booking_state    = $this->Booking->BookingState->find('list', array(
            'fields' => array('name', 'display')
        ));

        $this->set(compact('attendance_state', 'booking_state'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Booking->id = $id;
        if (!$this->Booking->exists()) {
            throw new NotFoundException(__('Diese Buchung existiert nicht.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Booking->save(array(
                'Booking' => array(
                    'courses_term_id'       => $this->request->data['Booking']['courses_term_id'],
                    'booking_state_name'    => $this->request->data['Booking']['booking_state_name'],
                    'attendance_state_name' => ($this->request->data['Booking']['attendance_state_name'] === '') ? null : $this->request->data['Booking']['attendance_state_name'],
                    'notes'                 => $this->request->data['Booking']['notes'],
                    'certificate'           => $this->request->data['Booking']['certificate']
                )
            ))
            ) {
                $this->Session->setFlash(__('Die Anmeldung wurde gepspeichert'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Es konnte nicht gespeichert werden'), 'flash_error');
            }
        }
        else {
            $this->request->data                               = $this->Booking->read(null, $id);
            $this->request->data['Booking']['unsubscribed_at'] = date("d.m.Y, H:i", strtotime($this->request->data['Booking']['unsubscribed_at'])) . ' Uhr';

            $users            = $this->Booking->User->find('list');
            $courses_terms    = $this->Booking->CoursesTerm->getCoursesList();
            $attendance_state = $this->Booking->AttendanceState->find('list');
            $types            = $this->Booking->Address->Type->find('list');

            $booking_state = $this->Booking->BookingState->find('list', array(
                'fields' => array('name', 'display')
            ));

            $this->set(compact('users', 'booking_state', 'attendance_state', 'courses_terms', 'types'));
        }
    }

    /**
     * @param null $id
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @throws Exception
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Booking->id = $id;
        if (!$this->Booking->exists()) {
            throw new NotFoundException(__('Ungültige Anmeldung'));
        }

        $deleted = $this->Booking->delete();

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            if (!$deleted) {
                throw new Exception(__('Fehler beim Speichern'));
            }
        }
        else {
            if ($deleted) {
                $this->Session->setFlash(__('Die Anmeldung wurde gelöscht'), 'flash_success');
                $this->redirect('/admin/bookings/index/sort:created/direction:desc');
            }
            else {
                $this->Session->setFlash(__('Der Anmeldung konnte nicht gelöscht werden'), 'flash_error');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    /**
     * The forms are built via ajax, only
     * the Address type if static in the form.
     *
     * @param null $term_id
     */
    public function index($term_id = null) {
        if ($this->request->is('ajax')) {
            $coursesByCategory = $this->Booking->CoursesTerm->findCoursesTermGroupedByCategoryWithBookingStateName(
                array('Editable' => $this->Auth->loggedIn(), 'User' => array('id' => $this->getUserId()))
            );

            $this->set(compact('coursesByCategory'));
            $this->set('_serialize', array('coursesByCategory'));
        }
    }

    /**
     * Attendees can only change their training status zu unsubscribed,
     * but they can't delete their booking.
     *
     * @return string
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     */
    public function delete() {
        $this->autoRender = false;

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        // Only mark as unsubscribed
        $this->Booking->query(
            "UPDATE bookings SET booking_state_name='self_unsubscribed', unsubscribed_at=CURRENT_TIMESTAMP() WHERE user_id = ? AND courses_term_id = ?",
            array($this->getUserId(), $this->request->data['CoursesTerm']['id'])
        );
        $this->Booking->query('UPDATE courses_terms CoursesTerm SET CoursesTerm.attendees = CoursesTerm.attendees - 1 WHERE CoursesTerm.id = ?', array($this->request->data['CoursesTerm']['id']));
        $message = array('message' => __('Sie wurden von dem Kurs abgemeldet, Sie können sich auch wieder selbst anmelden'));
        return json_encode($message);
    }

    /**
     * Move a set of bookings to another CoursesTerm.
     * This gets a request from the courses_terms/view page.
     */
    public function admin_confirm_move() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        if (!isset($this->request->data['Booking']['id'])) {
            $this->Session->setFlash(__('Die haben keine Teilnehmer ausgewählt'), 'flash_success');
            return $this->redirect('/admin/courses_terms/view/' . $this->request->data['CoursesTerm']['id']);
        }

        // Extract the selected booking ids
        $booking_ids = array();

        foreach ($this->request->data['Booking']['id'] as $id => $on) {
            array_push($booking_ids, intval($id));
        }
        // Flatten for SQL IN clause
        $booking_ids = implode(',', $booking_ids);

        $bookings = $this->Booking->query("
            SELECT
                Booking.id, User.id,User.title,User.firstname,User.lastname,BookingState.display,AttendanceState.display
            FROM bookings Booking
                LEFT JOIN users User ON (Booking.user_id = User.id)
                LEFT OUTER JOIN booking_states BookingState ON (Booking.booking_state_name = BookingState.name)
                LEFT OUTER JOIN attendance_states AttendanceState ON (Booking.attendance_state_name = AttendanceState.name)
            WHERE
                Booking.id IN (" . $booking_ids . ")
            ORDER BY
                Booking.booking_state_name ASC
        ");

        // Current course data
        $this->Booking->CoursesTerm->recursive = 0;

        $coursesTerm      = $this->Booking->CoursesTerm->findById($this->request->data['CoursesTerm']['id']);
        $title_for_layout = __('Verschieben von Anmeldungen');

        $this->set(compact('bookings', 'coursesTerm', 'title_for_layout'));
    }

    public function admin_move() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        // Extract the selected booking ids
        $booking_ids = array();

        foreach ($this->request->data['Booking']['id'] as $id => $on) {
            array_push($booking_ids, intval($id));
        }
        // Flatten for SQL IN clause
        $booking_ids = implode(',', $booking_ids);

        $this->Booking->query(
            'UPDATE bookings Booking SET Booking.courses_term_id = ? WHERE Booking.id IN (' . $booking_ids . ')',
            array($this->request->data['Booking']['courses_term_id'])
        );

        $this->Session->setFlash(__('Die Anmeldungen wurden verschoben'), 'flash_success');
        $this->redirect('/admin/courses_terms/view/' . $this->request->data['Booking']['courses_term_id']);
    }

}
