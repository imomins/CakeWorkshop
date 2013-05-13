<?php
App::uses('AppController', 'Controller');
/**
 * Courses Controller
 *
 * @property Course $Course
 */
class CoursesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Course->recursive = 0;
        $this->set('courses', $this->paginate());

        $title_for_layout = __('Kursübersicht');
        $this->set(compact('title_for_layout'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Course->id = $id;
        if (!$this->Course->exists()) {
            throw new NotFoundException(__('Invalid course'));
        }

        $result = $this->Course->query('
            SELECT Course.*,Category.*,Term.name,CoursesTerm.id,Schedule.display FROM courses Course
                LEFT JOIN courses_terms CoursesTerm ON (Course.id = CoursesTerm.course_id)
                LEFT JOIN categories Category ON (Course.category_id = Category.id)
                LEFT JOIN terms Term ON (CoursesTerm.term_id = Term.id)
                LEFT JOIN schedules Schedule ON (CoursesTerm.schedule_name = Schedule.name)
            WHERE Course.id = ?;
        ', array($id));

        $course['children'] = $result;
        // The data are repetitions, copy to root to main course data
        $course['Term']     = $course['children'][0]['Term'];
        $course['Course']   = $course['children'][0]['Course'];
        $course['Category'] = $course['children'][0]['Category'];

        $title_for_layout = $course['Course']['name'];

        $this->set(compact('course', 'title_for_layout'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Course->create();
            if ($this->Course->save($this->request->data)) {
                $this->Session->setFlash(__('Der Kurs wurde gespeichert'), 'flash_success');
                $this->redirect(array('action' => 'view', $this->Course->getLastInsertID()));
            }
            else {
                $this->Session->setFlash(__('The course could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Course->Category->find('list');
        $terms      = $this->Course->Term->find('list');
        $title_for_layout = __('Kurs anlegen');

        $this->set(compact('categories', 'terms', 'title_for_layout'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Course->recursive = -1;
        $this->Course->id        = $id;
        if (!$this->Course->exists()) {
            throw new NotFoundException(__('Invalid course'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Course->save($this->request->data)) {
                $this->Session->setFlash(__('Der Kurs wurde gespeichert'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Es ist ein Fehler beim Speichern des Kurses aufgetreten'));
            }
        }
        else {
            $this->request->data = $this->Course->read(null, $id);
        }

        // We find related courses that are set for terms
        $this->loadModel('CoursesTerm');
        $this->CoursesTerm->unbindModel(
            array(
                'hasMany'   => array('Booking', 'Day'),
                'belongsTo' => array('Course')
            )
        );
        $courses_terms = $this->CoursesTerm->find('all',
            array(
                'fields'     => array(
                    'CoursesTerm.id', 'CoursesTerm.attendees', 'CoursesTerm.max', 'Term.name', 'Schedule.display'),
                'recursive'  => 0,
                'conditions' => array('CoursesTerm.course_id' => $id),
                'order'      => 'CoursesTerm.id DESC'
            )
        );

        $categories = $this->Course->Category->find('list');
        $this->set(compact('categories', 'terms', 'courses_terms'));
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
        $this->Course->id = $id;
        if (!$this->Course->exists()) {
            throw new NotFoundException(__('Invalid course'));
        }
        if ($this->Course->delete()) {
            $this->Session->setFlash(__('Course deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Course was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
