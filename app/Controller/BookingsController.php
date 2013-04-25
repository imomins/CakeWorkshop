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

    public $paginate = array(
        'order'   => array('Booking.created DESC'),
        'contain' => array(
            'User'        => array(
                'fields' => array('User.id', 'User.name')
            ),
            'CoursesTerm' => array(
                'Course' => array(
                    'fields' => array('Course.name')
                ),
                'Term'   => array(
                    'fields' => array('Term.id', 'Term.name')
                )
            )
        )
    );

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
        $this->paginate = array(
            'order'   => array('Booking.created' => 'DESC'),
            'contain' => array(
                'User'        => array('fields' => array('name', 'id')),
                'CoursesTerm' => array(
                    'Course' => array('fields' => array('name')),
                    'Term'   => array('conditions' => array('Term.id' => $termId))
                )
            )
        );
        if ($this->request->is('post')) {
            $this->paginate['contain']['CoursesTerm']['Course'] = array(
                'fields'     => array('name'),
                'conditions' => array('Course.name' => trim($this->request->data['Course']['name']))
            );
        }

        $bookings = $this->paginate('Booking');

        $terms = $this->Booking->CoursesTerm->Term->find('list');

        $this->set(compact('bookings', 'terms'));
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
            throw new NotFoundException(__('Invalid courses terms user'));
        }
        $booking = $this->Booking->find('first', array(
            'conditions' => array('Booking.id' => $id),
            'contain'    => array(
                'Invoice',
                'CoursesTerm' => array(
                    'Course', 'Term'
                ),
                'User'        => array(
                    'fields' => array('User.id', 'User.name')
                ),
            )
        ));
        $this->set('booking', $booking);
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
                'Booking.invoice_id'         => $this->request->data['Invoice']['id'],
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
                $sql = "INSERT INTO bookings (user_id,courses_term_id,invoice_id,booking_state_name) VALUES (?,?,?,'unconfirmed')";
                $this->Booking->query($sql, array($this->getUserId(), $id, $this->request->data['Invoice']['id']));
                $status = true;
            }

            if (!$status) {
                throw new Exception(__('Es ist ein Fehler aufgetreten: ') . json_encode($this->Booking->validationErrors));
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

    /**
     * add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Booking->create();
            if ($this->Booking->save($this->request->data)) {
                $this->Session->setFlash(__('The courses terms user has been saved'));
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('The courses terms user could not be saved. Please, try again.'));
            }
        }

        $invoices     = $this->Booking->Invoice->find('list');
        $users        = $this->Booking->User->find('list');
        $coursesTerms = $this->Booking->CoursesTerm->getCoursesList();
        $types        = $this->Booking->Invoice->Type->find('list');

        $this->set(compact('users', 'coursesTerms', 'types', 'invoices'));
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
            if ($this->Booking->save($this->request->data)) {
                $this->Session->setFlash(__('Daten gespeichert'));
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Es konnte nicht gespeichert werden'));
            }
        }
        else {
            $this->request->data = $this->Booking->read(null, $id);
        }
        $booking = $this->Booking->find('first');
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
        $this->Booking->id = $id;
        if (!$this->Booking->exists()) {
            throw new NotFoundException(__('Invalid courses terms user'));
        }
        if ($this->Booking->delete()) {
            $this->Session->setFlash(__('Die Buchung wurde gelöscht'));
            $this->redirect('/admin/bookings/index/sort:created/direction:desc');
        }
        $this->Session->setFlash(__('Courses terms user was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * The forms are built via ajax, only
     * the invoice type if static in the form.
     *
     * @param null $term_id
     */
    public function index($term_id = null) {
        if ($this->request->is('ajax')) {
            $coursesByCategory = $this->Booking->CoursesTerm->findCoursesTermGroupedByCategoryWithBookingStateName(
                array('Editable' => true, 'User' => array('id' => $this->getUserId()))
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
        $message = array('message' => __('Sie wurden von dem Kurs abgemeldet, Sie können sich auch wieder selbst anmelden'));
        return json_encode($message);
    }

}
