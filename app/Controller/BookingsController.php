<?php
App::uses('AppController', 'Controller');
/**
 * Bookings Controller
 * @property Booking $Booking
 */
class BookingsController extends AppController {

    public $components = array('RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
        $this->paginate = array(
            'order' => array('Booking.created DESC'),
            'contain' => array(
                'User' => array(
                    'fields' => array('User.id', 'User.name')
                ),
                'CoursesTerm' => array(
                    'Course' => array(
                        'fields' => array('Course.name')
                    ),
                    'Term' => array(
                        'fields' => array('Term.id', 'Term.name')
                    )
                )
            )
        );
        $bookings = $this->paginate('Booking');
        $terms = $this->Booking->CoursesTerm->Term->find('list');

		$this->set(compact('bookings', 'terms'));
	}

/**
 *
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
            'contain' => array(
                'CoursesTerm' => array(
                    'Course'
                ),
                'User' => array(
                    'fields' => array('User.id', 'User.name')
                ),
            )
        ));
        $this->set('booking', $booking);
	}

    public function add() {
        if ($this->request->is('post')) {
            $this->Booking->create();

            // AJAX Request
            if ($this->request->is('ajax')) {
                if ($this->Booking->save(array(
                    'Booking' => array(
                        'user_id' => $this->getUserId(),
                        'courses_term_id' => $this->request->data('course_term_id'),
                        'invoice_id' => $this->request->data('invoice_id'),
                    )
                ))) {
                    $this->autoRender = false;
                    return json_encode(array('message' => __('Der Kurs wurde gebucht'), 'id' => $this->Booking->id));
                }

            // Regular post request
            } else {
                    if ($this->Booking->save(array(
                    'Booking' => array(
                        'user_id' => $this->getUserId(),
                        'courses_term_id' => $this->request->data['Booking']['courses_term_id'],
                        'invoice_id' => $this->request->data['Booking']['invoice_id'],
                        'commitment' => $this->request->data['Booking']['commitment'],
                        'completed' => $this->request->data['Booking']['completed'],
                        'certificate' => $this->request->data['Booking']['certificate'],
                    )
                ))) {
                    $this->Session->setFlash(__('The courses terms user has been saved'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The courses terms user could not be saved. Please, try again.'));
                }
            }
        }

        $invoices = $this->Booking->Invoice->find('list');
        $users = $this->Booking->User->find('list');
        $coursesTerms = $this->Booking->CoursesTerm->getCoursesList();
        $types = $this->Booking->Invoice->Type->find('list');

        $this->set(compact('users', 'coursesTerms', 'types', 'invoices'));
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
			} else {
				$this->Session->setFlash(__('The courses terms user could not be saved. Please, try again.'));
			}
		}

        $invoices = $this->Booking->Invoice->find('list');
        $users = $this->Booking->User->find('list');
        $coursesTerms = $this->Booking->CoursesTerm->getCoursesList();
		$types = $this->Booking->Invoice->Type->find('list');

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
			throw new NotFoundException(__('Invalid courses terms user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Booking->save($this->request->data)) {
				$this->Session->setFlash(__('The courses terms user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The courses terms user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Booking->read(null, $id);
		}
		$users = $this->Booking->User->find('list');
		$coursesTerms = $this->Booking->CoursesTerm->getCoursesList();
		$invoices = $this->Booking->Invoice->find('list');
		$this->set(compact('users', 'coursesTerms', 'invoices'));
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
			$this->Session->setFlash(__('Courses terms user deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Courses terms user was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

    public function index($term_id = null) {
        $bookedCourses = $this->Booking->find('all',
            array(
                'fields' => array('Booking.courses_term_id'),
                'conditions' => array('Booking.user_id' => $this->getUserId())
            )
        );
        // Flattens the array for the NOT IN query in findGroupedByCategory
        // array('Booking.courses_term_id_1', ...)
        $bookedCourses= Set::format($bookedCourses, '{0}', array('{n}.Booking.courses_term_id'));

        $coursesByCategory = $this->Booking->CoursesTerm->Course->Category->findGroupedByCategory(
            array('CoursesTerm' => $bookedCourses)
        );

        $types = $this->Booking->Invoice->Type->find('list');
        $terms = $this->Booking->CoursesTerm->Term->find('list');
        $invoices = $this->Booking->Invoice->find('list', array('conditions' => array('Invoice.user_id' => $this->getUserId())));
        $bookings = $this->Booking->findBookingsByUserId($this->getUserId());
        //debug($bookings);

        $this->set(compact('types', 'terms', 'coursesByCategory', 'bookings', 'term_id', 'invoices'));
        $this->set('_serialize', array('bookings', 'coursesByCategory'));
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Booking->id = $id;

        $booking = $this->Booking->find('first', array(
            'conditions' => array('Booking.id' => $id, 'Booking.user_id' => $this->getUserId())
        ));

        if (!is_array($booking) || !$this->Booking->exists()) {
            throw new NotFoundException(__('Ungültige Buchung'), 'flash_error');
        }
        if ($this->Booking->delete()) {
            $this->Session->setFlash(__('Die Buchung wurde gelöscht'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Die Buchung konnte nicht gelöscht werden'), 'flash_error');
        $this->redirect(array('action' => 'index'));
    }


}
