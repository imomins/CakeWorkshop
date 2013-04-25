<?php
App::uses('AppController', 'Controller');
/**
 * Types Controller
 *
 * @property Type $Type
 */
class TypesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Type->recursive = 0;
        $this->set('types', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Type->id = $id;
        if (!$this->Type->exists()) {
            throw new NotFoundException(__('Untültiger typ'), 'flash_error');
        }
        $this->set('type', $this->Type->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Type->create();
            if ($this->Type->save($this->request->data)) {
                $this->Session->setFlash(__('Der Typ wurde gepspeichert'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Der Typ konnte nicht gespeichert werden'), 'flash_error');
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
        $this->Type->id = $id;
        if (!$this->Type->exists()) {
            throw new NotFoundException(__('Invalid type'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Type->save($this->request->data)) {
                $this->Session->setFlash(__('Der Typ wurde gespeichert'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Der Typ konnte nicht gespeichert werden'), 'flash_error');
            }
        }
        else {
            $this->request->data = $this->Type->read(null, $id);
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
        $this->Type->id = $id;
        if (!$this->Type->exists()) {
            throw new NotFoundException(__('Untültiger typ'), 'flash_error');
        }
        if ($this->Type->delete()) {
            $this->Session->setFlash(__('Typ gelöscht'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Der Typ wurde nicht gelöscht'), 'flash_error');
        $this->redirect(array('action' => 'index'));
    }
}
