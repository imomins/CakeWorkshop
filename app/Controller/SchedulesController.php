<?php
App::uses('AppController', 'Controller');
/**
 * Schedules Controller
 *
 * @property Schedule $Schedule
 */
class SchedulesController extends AppController {

    public $helpers = array('Frontend');

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Schedule->recursive = 0;
        $this->set('schedules', $this->paginate());
    }

    /**
     * @param $schedule_name
     * @param int $page
     * @param int $pageSize
     * @throws NotFoundException
     */
    public function admin_view($schedule_name, $page = 0, $pageSize = 15) {
        if (!$this->Schedule->exists($schedule_name)) {
            throw new NotFoundException(__('Ungültiger Status'));
        }

        // Custom pagination this is more efficient
        $schedule['CoursesTerm'] = $this->Schedule->query("
            SELECT Schedule.display,CoursesTerm.*,Course.name,Term.*
                FROM schedules Schedule
                    LEFT OUTER JOIN courses_terms CoursesTerm ON (Schedule.name = CoursesTerm.schedule_name)
                    LEFT OUTER JOIN courses Course ON (CoursesTerm.course_id = Course.id)
                    LEFT OUTER JOIN terms Term ON (CoursesTerm.term_id = Term.id)
            WHERE Schedule.name = ?
                ORDER BY CoursesTerm.id DESC
            LIMIT " . intval($page * $pageSize) . ", " . intval($pageSize)
            , array($schedule_name));

        $result               = $this->Schedule->query('SELECT * FROM schedules Schedule WHERE Schedule.name = ?', array($schedule_name));
        $schedule['Schedule'] = $result[0]['Schedule'];

        $count = $this->Schedule->query("SELECT COUNT(*) result FROM courses_terms CoursesTerm WHERE CoursesTerm.schedule_name = ?", array($schedule_name));
        $count = $count[0][0]['result'];

        $pages = ceil($count / $pageSize);

        $this->set(compact('schedule', 'page', 'count', 'pages'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Schedule->create();
            if ($this->Schedule->save($this->request->data)) {
                $this->Session->setFlash(__('The schedule has been saved'));
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('The schedule could not be saved. Please, try again.'));
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
        if (!$this->Schedule->exists($id)) {
            throw new NotFoundException(__('Invalid schedule'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Schedule->save($this->request->data)) {
                $this->Session->setFlash(__('The schedule has been saved'));
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('The schedule could not be saved. Please, try again.'));
            }
        }
        else {
            $options             = array('conditions' => array('Schedule.' . $this->Schedule->primaryKey => $id));
            $this->request->data = $this->Schedule->find('first', $options);
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
        $this->Schedule->id = $id;
        if (!$this->Schedule->exists()) {
            throw new NotFoundException(__('Invalid schedule'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Schedule->delete()) {
            $this->Session->setFlash(__('Schedule deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Schedule was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
