<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Category->recursive = 0;
        $this->set('categories', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Ungültige Kategorie'), 'flash_error');
        }
        $category = $this->Category->read(null, $id);
        $title_for_layout = $category['Category']['name'];

        $this->set(compact('category', 'title_for_layout'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('Kategorie gespeichert'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Kategorie konnte nicht gespeichert werden'), 'flash_error');
            }
        }
        else {
            $title_for_layout = __('Kategorie anlegen');
            $this->set(compact('title_for_layout'));
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
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Ungültige Kategorie'), 'flash_error');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('Kategorie gespeichert'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Kategorie konnte nicht gespeichert werden'), 'flash_error');
            }
        }
        else {
            $this->request->data = $this->Category->read(null, $id);
            $title_for_layout = $this->request->data['Category']['name'];
            $this->set(compact('title_for_layout'));
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
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Ungültige Kateogorie'), 'flash_error');
        }
        if ($this->Category->delete()) {
            $this->Session->setFlash(__('Kategorie gelöscht'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Kategorie konnte nicht gelöscht werden'), 'flash_error');
        $this->redirect(array('action' => 'index'));
    }
}
