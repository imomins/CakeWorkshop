<?php
App::uses('AppController', 'Controller');
/**
 * Occupations Controller
 *
 * @property Occupation $Occupation
 */
class OccupationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Occupation->recursive = 0;
		$this->set('occupations', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Occupation->id = $id;
		if (!$this->Occupation->exists()) {
			throw new NotFoundException(__('Invalid occupation'));
		}
		$this->set('occupation', $this->Occupation->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Occupation->create();
			if ($this->Occupation->save($this->request->data)) {
				$this->Session->setFlash(__('The occupation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The occupation could not be saved. Please, try again.'));
			}
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
		$this->Occupation->id = $id;
		if (!$this->Occupation->exists()) {
			throw new NotFoundException(__('Invalid occupation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Occupation->save($this->request->data)) {
				$this->Session->setFlash(__('The occupation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The occupation could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Occupation->read(null, $id);
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
		$this->Occupation->id = $id;
		if (!$this->Occupation->exists()) {
			throw new NotFoundException(__('Invalid occupation'));
		}
		if ($this->Occupation->delete()) {
			$this->Session->setFlash(__('Occupation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Occupation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
