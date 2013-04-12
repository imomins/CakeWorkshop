<?php
App::uses('AppController', 'Controller');
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
     * @return string json
     */
    public function add() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $this->Booking->create();

            if ($this->Booking->save(array(
                'Booking' => array(
                    'user_id'            => $this->getUserId(),
                    'courses_term_id'    => $this->request->data['CoursesTerm']['id'],
                    'invoice_id'         => $this->request->data['Invoice']['id'],
                    'booking_state_name' => 'unconfirmed'
                )
            ))
            ) {
                return json_encode(array('message' => __('Der Kurs wurde gebucht'), 'id' => $this->Booking->id));
            }
            else {
                return json_encode(array('message' => __('Der Kurs konnte nicht gebucht werden: ' . json_encode($this->Booking->validationErrors))));
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

    public function index($term_id = null) {
        $coursesByCategory = $this->Booking->findCoursesTermGroupedByCategoryWithBookingStateName(
            array('User' => array('id' => $this->getUserId()))
        );
        $types    = $this->Booking->Invoice->Type->find('list');
        $terms    = $this->Booking->CoursesTerm->Term->find('list');
        $invoices = $this->Booking->Invoice->find('list', array('conditions' => array('Invoice.user_id' => $this->getUserId())));

        $this->set(compact('types', 'terms', 'coursesByCategory', 'bookings', 'term_id', 'invoices'));
    }

    /**
     * Attendees can only change their training status zu unsubscribed,
     * but they can't delete their booking.
     *
     * @param $id
     * @return string
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     */
    public function delete($id) {
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        // Be sure it's the user's own booking
        $booking = $this->Booking->find('first', array(
            'conditions' => array(
                'Booking.id'      => $id,
                'Booking.user_id' => $this->getUserId()
            )
        ));
        if (!is_array($booking) || empty($booking)) {
            throw new NotFoundException(__('Ungültige Buchung'), 'flash_error');
        }

        $this->Booking->id = $id;
        if ($this->Booking->saveField('booking_state_name', 'self_unsubscribed')) {
            $message = array('message' => __('Sie wurden von dem Kurs abgemeldet, Sie können sich auch wieder selbst anmelden'));
        }
        else {
            $message = array('message' => __('Ein Fehler ist aufgetreten: ') . json_encode($this->Booking->validationErrors));
        }
        return json_encode($message);
    }

}
