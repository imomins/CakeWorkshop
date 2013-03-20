<?php
App::uses('AppController', 'Controller');
/**
 * Invoices Controller
 *
 * @property Invoice $Invoice
 */
class InvoicesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Invoice->recursive = 0;
		$this->set('invoices', $this->paginate());
	}

    public function index() {
        $this->Invoice->recursive = 0;
        $this->set('invoices', $this->paginate());
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
        $invoice = $this->Invoice->find('first', array(
            'conditions' => array(
                'Invoice.id' => $id,
            ),
            'contain' => array(
                'Type' => array('fields' => 'name'),
                'Booking' => array(
                    'CoursesTerm' => array(
                        'Term' => array('fields' => array('Term.name')),
                        'fields' => array('CoursesTerm.id'),
                        'Course' => array('fields' => 'Course.name')
                    )
                )
            )
        ));

        if (empty($invoice)) {
            throw new NotFoundException(__('Ungültige Rechnung'));

        }
        $this->set('invoice', $invoice);
	}

    public function view($id = null) {
        $invoice = $this->Invoice->find('first', array(
            'conditions' => array(
                'Invoice.user_id' => $this->getUserId(),
                'Invoice.id' => $id,
            ),
            'contain' => array(
                'Type' => array('fields' => 'name'),
                'Booking' => array(
                    'CoursesTerm' => array(
                        'Term' => array('fields' => array('Term.name')),
                        'fields' => array('CoursesTerm.id'),
                        'Course' => array('fields' => 'Course.name')
                    )
                )
            )
        ));

        if (empty($invoice)) {
            throw new NotFoundException(__('Ungültige Rechnung'));

        }
        $this->set('invoice', $invoice);
    }

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Invoice->create();
			if ($this->Invoice->save($this->request->data)) {
				$this->Session->setFlash(__('The invoice has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invoice could not be saved. Please, try again.'));
			}
		}
		$types = $this->Invoice->Type->find('list');
        $users = $this->Invoice->User->find('list');
		$this->set(compact('types', 'users'));
	}

    public function add() {
        if ($this->request->is('post')) {
            $this->Invoice->create();

            if ($this->Invoice->save(array(
                'Invoice' => array(
                    'name' => $this->request->data['Invoice']['name'],
                    'type_id'     => $this->request->data['Invoice']['type_id'],
                    'user_id'     => $this->getUserId(),
                    'institution' => $this->request->data['Invoice']['institution'],
                    'department'  => $this->request->data['Invoice']['department'],
                    'postbox'     => $this->request->data['Invoice']['postbox'],
                    'to_person'   => $this->request->data['Invoice']['to_person'],
                    'street'      => $this->request->data['Invoice']['street'],
                    'zip'         => $this->request->data['Invoice']['zip'],
                    'location'    => $this->request->data['Invoice']['location'],
                )
            ))) {
                if ($this->request->is('ajax')) {
                    $this->autoRender = false;
                    return json_encode(array('message' => __('Die Vorlage wurde gespeichert'), 'id' => $this->Invoice->id, 'name' => $this->Invoice->name));
                } else {
                    $this->Session->setFlash(__('The invoice has been saved'));
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->Session->setFlash(__('The invoice could not be saved. Please, try again.'));
            }
        }
        $types = $this->Invoice->Type->find('list');
        $this->set(compact('types'));
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Invoice->id = $id;
		if (!$this->Invoice->exists()) {
			throw new NotFoundException(__('Invalid invoice'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Invoice->save($this->request->data)) {
				$this->Session->setFlash(__('The invoice has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invoice could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Invoice->read(null, $id);
		}
		$types = $this->Invoice->Type->find('list');
		$this->set(compact('types'));
	}

    public function edit($id = null) {
        $this->Invoice->recursive = -1;
        $invoice = $this->Invoice->find('first', array(
            'conditions' => array('Invoice.id' => $id, 'Invoice.user_id' => $this->getUserId())
        ));

        if (!is_array($invoice)) {
            throw new NotFoundException(__('Ungültige Rechnung'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Invoice->save(array(
                'Invoice' => array(
                    'id' => $id,
                    'name' => $this->request->data['Invoice']['name'],
                    'type_id'     => $this->request->data['Invoice']['type_id'],
                    'user_id'     => $this->getUserId(),
                    'institution' => $this->request->data['Invoice']['institution'],
                    'department'  => $this->request->data['Invoice']['department'],
                    'postbox'     => $this->request->data['Invoice']['postbox'],
                    'to_person'   => $this->request->data['Invoice']['to_person'],
                    'street'      => $this->request->data['Invoice']['street'],
                    'zip'         => $this->request->data['Invoice']['zip'],
                    'location'    => $this->request->data['Invoice']['location'],
                )
            ))) {
                $this->Session->setFlash(__('The invoice has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The invoice could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $invoice;
        }
        $types = $this->Invoice->Type->find('list');
        $this->set(compact('types'));
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
		$this->Invoice->id = $id;
		if (!$this->Invoice->exists()) {
			throw new NotFoundException(__('Invalid invoice'));
		}
		if ($this->Invoice->delete()) {
			$this->Session->setFlash(__('Invoice deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Invoice was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Invoice->id = $id;
        if (!$this->Invoice->exists()) {
            throw new NotFoundException(__('Invalid invoice'));
        }
        if ($this->Invoice->delete()) {
            $this->Session->setFlash(__('Invoice deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Invoice was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
