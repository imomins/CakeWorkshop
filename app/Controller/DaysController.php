<?php
App::uses('AppController', 'Controller');
/**
 * Days Controller
 *
 * @property Day $Day
 */
class DaysController extends AppController {

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Day->recursive = 0;
        $this->set('days', $this->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Day->id = $id;
        if (!$this->Day->exists()) {
            throw new NotFoundException(__('Invalid day'));
        }
        $this->set('day', $this->Day->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @param $id
     */
    public function admin_add($id) {
        if ($this->request->is('post')) {
            $this->Day->create();
            $this->request->data['Day']['courses_term_id'] = $id;
            if ($this->Day->save($this->request->data)) {
                $this->Session->setFlash(__('Der Tag wurde gespeichert'), 'flash_success');
                $this->redirect(array('controller' => 'courses_terms', 'action' => 'view', $id));
            }
            else {
                $this->Session->setFlash(__('Fehler beim Speichern: ') . json_encode($this->Day->validationErrors), 'flash_error');
            }
        }
        $coursesTerms = $this->Day->CoursesTerm->findById($id);
        $this->set(compact('coursesTerms'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Day->id = $id;
        if (!$this->Day->exists()) {
            throw new NotFoundException(__('Invalid day'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Day->save($this->request->data)) {
                $this->Session->setFlash(__('The day has been saved'));
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('The day could not be saved. Please, try again.'));
            }
        }
        else {
            $this->request->data = $this->Day->read(null, $id);
        }
        $coursesTerms = $this->Day->CoursesTerm->find('list');
        $this->set(compact('coursesTerms'));
    }

    /**
     * admin_delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Day->id = $id;
        if (!$this->Day->exists()) {
            throw new NotFoundException(__('Der Tag existiert nicht'), 'flash_error');
        }
        // For redirect back
        $this->Day->recursive = -1;
        $courses_term_id      = $this->Day->read(array('Day.courses_term_id'), $id);

        if ($this->Day->delete()) {
            $this->Session->setFlash(__('Der Tag wurde gelöscht'), 'flash_success');
        }
        else {
            $this->Session->setFlash(__('Der Tag konnte nicht gelöscht werden'), 'flash_error');
        }
        $this->redirect('/admin/courses_terms/view/' . $courses_term_id['Day']['courses_term_id']);
    }
}
