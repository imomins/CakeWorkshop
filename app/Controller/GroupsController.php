<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 */
class GroupsController extends AppController {

    public $components = array('RequestHandler');

    public $paginate = array(
        'limit' => 20,
        'order' => array('name ASC')
    );

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Group->recursive = 0;
        $this->set('groups', $this->paginate());
    }

    /**
     * admin_view method
     * {
    "Result":"OK",
    "Records":[
     *
     * @throws NotFoundException
     * @param string $group_name
     * @return void
     */
    public function admin_view($group_name = null) {
        if (!$this->Group->exists($group_name)) {
            throw new NotFoundException(__('Invalid group'));
        }

        $groups = $this->Group->findByName($group_name);
        if ($this->request->is('ajax')) {
            $groups['User'] = $this->Group->User->query('SELECT id,title,firstname,lastname,email,active,created FROM users WHERE group_name = ?', array($group_name));
        }
        $this->set('groups', $groups);
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Group->create();
            if ($this->Group->save($this->request->data)) {
                $this->Session->setFlash(__('The group has been saved'));
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('The group could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->Group->exists($id)) {
            throw new NotFoundException(__('Invalid group'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Group->save($this->request->data)) {
                $this->Session->setFlash(__('The group has been saved'));
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('The group could not be saved. Please, try again.'));
            }
        }
        else {
            $options             = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
            $this->request->data = $this->Group->find('first', $options);
        }
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Group->id = $id;
        if (!$this->Group->exists()) {
            throw new NotFoundException(__('Invalid group'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Group->delete()) {
            $this->Session->setFlash(__('Group deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Group was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
