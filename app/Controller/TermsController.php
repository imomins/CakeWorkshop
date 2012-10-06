<?php
App::uses('AppController', 'Controller');
/**
 * Terms Controller
 *
 * @property Term $Term
 */
class TermsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Term->recursive = 0;
		$this->set('terms', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Term->id = $id;
		if (!$this->Term->exists()) {
			throw new NotFoundException(__('Invalid term'));
		}
		$this->set('term', $this->Term->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Term->create();
			if ($this->Term->save($this->request->data)) {
				$this->Session->setFlash(__('The term has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The term could not be saved. Please, try again.'));
			}
		}
		$courses = $this->Term->Course->find('list');
		$this->set(compact('courses'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Term->id = $id;
		if (!$this->Term->exists()) {
			throw new NotFoundException(__('Invalid term'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Term->save($this->request->data)) {
				$this->Session->setFlash(__('The term has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The term could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Term->read(null, $id);
		}
		$courses = $this->Term->Course->find('list');
		$this->set(compact('courses'));
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
		$this->Term->id = $id;
		if (!$this->Term->exists()) {
			throw new NotFoundException(__('Invalid term'));
		}
		if ($this->Term->delete()) {
			$this->Session->setFlash(__('Term deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Term was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
