<?php
App::uses('AppController', 'Controller');
/**
 * CoursesTerms Controller
 *
 * @property CoursesTerm $CoursesTerm
 */
class CoursesTermsController extends AppController {

    public $components = array('RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
        $this->paginate = array(
            'fields' => array(
                'CoursesTerm.id',
                'CoursesTerm.attendees',
                'CoursesTerm.max'
            ),
            'contain' => array(
                'Day',
                'Term' => array('fields' => array('Term.id', 'Term.name')),
                'Course' => array('fields' => array('Course.id', 'Course.label'))
            )
        );
        $p = $this->paginate();
		$this->set('coursesTerms', $p);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->CoursesTerm->id = $id;
		if (!$this->CoursesTerm->exists()) {
			throw new NotFoundException(__('Invalid courses term'));
		}
        $params = array(
            'download' => true,
            'name' => 'example.pdf',
            'paperOrientation' => 'portrait',
            'paperSize' => 'legal'
        );
        $this->set($params);
		$this->set('coursesTerm', $this->CoursesTerm->read(null, $id));
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
				$this->Session->setFlash(__('The courses term has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The courses term could not be saved. Please, try again.'));
			}
		}
		$terms = $this->CoursesTerm->Term->find('list');
		$courses = $this->CoursesTerm->Course->find('list');
		$users = $this->CoursesTerm->User->find('list');
		$this->set(compact('terms', 'courses', 'users'));
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
				$this->Session->setFlash(__('The courses term has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The courses term could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CoursesTerm->read(null, $id);
		}
		$terms = $this->CoursesTerm->Term->find('list');
		$courses = $this->CoursesTerm->Course->find('list');
		$users = $this->CoursesTerm->User->find('list');
		$this->set(compact('terms', 'courses', 'users'));
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
}
