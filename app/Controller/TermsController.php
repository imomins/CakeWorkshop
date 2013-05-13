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
        $this->set('title_for_layout', __('Semester-Übersicht'));
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
            throw new NotFoundException(__('Unbekanntes Semester'));
        }

        $terms = $this->Term->find('all', array(
            'recursive'  => -1,
            'conditions' => array('Term.id' => $id),
            'fields'     => array('CoursesTerm.id', 'Term.*', 'Course.name'),
            'joins'      => array(
                array(
                    'table'      => 'courses_terms',
                    'alias'      => 'CoursesTerm',
                    'type'       => 'LEFT',
                    'conditions' => array(
                        'Term.id = CoursesTerm.term_id',
                    )
                ),
                array(
                    'table'      => 'courses',
                    'alias'      => 'Course',
                    'type'       => 'LEFT',
                    'conditions' => array(
                        'CoursesTerm.course_id = Course.id',
                    )
                )
            )
        ));

        $title_for_layout = $terms[0]['Term']['name'];
        $this->set(compact('terms', 'title_for_layout'));
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
        else {
            $this->set('title_for_layout', __('Semester Anlegen'));
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
