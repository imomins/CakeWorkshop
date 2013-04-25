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

        $terms = $this->Term->find('all', array(
            'recursive'  => 2,
            'conditions' => array('Term.id' => $id),
            'fields'     => array('Term.name', 'CoursesTerm.max')
        ));
        debug($terms);

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
                $this->Session->setFlash(__('Das Semester wurde angelegt'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Speichern fehlgeschlagen'), 'flash_error');
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
        $this->Term->id = $id;
        if (!$this->Term->exists()) {
            throw new NotFoundException(__('Invalid term'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Term->save($this->request->data)) {
                $this->Session->setFlash(__('Das Semester wurde gespeichert'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Fehler beim Speichern'), 'flash_error');
            }
        }
        else {
            $this->request->data = $this->Term->read(null, $id);
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
        $this->Term->id = $id;
        if (!$this->Term->exists()) {
            throw new NotFoundException(__('Ungültiges Semester'));
        }
        if ($this->Term->delete()) {
            $this->Session->setFlash(__('Semester gelöscht'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Das Semester wurde nicht gelöscht'), 'flash_error');
        $this->redirect(array('action' => 'index'));
    }
}
