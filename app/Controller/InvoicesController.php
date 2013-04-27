<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

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
        $this->autoRender = false;

        $invoices = $this->Invoice->find(
            'all',
            array(
                'recursive'  => -1,
                'fields'     => array('id', 'type_name', 'institution', 'department', 'postbox', 'to_person', 'street', 'zip', 'location', 'name'),
                'conditions' => array('user_id' => $this->getUserId())
            )
        );
        return json_encode($invoices);
    }

    public function types() {
        $this->autoRender               = false;
        $this->Invoice->Type->recursive = -1;
        $types                          = $this->Invoice->Type->find('all');
        return json_encode($types);
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
            'contain'    => array(
                'User'    => array('fields' => array('name', 'id')),
                'Type'    => array('fields' => 'name'),
                'Booking' => array(
                    'CoursesTerm' => array(
                        'Term'   => array('fields' => array('Term.name')),
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

    public function view($id) {
        $this->autoRender = false;

        $invoices = $this->Invoice->find(
            'first',
            array(
                'recursive'  => -1,
                'fields'     => array('id', 'type_name', 'institution', 'department', 'postbox', 'to_person', 'street', 'zip', 'location', 'name'),
                'conditions' => array('user_id' => $this->getUserId(), 'id' => $id)
            )
        );
        if (sizeof($invoices) > 0) {
            return json_encode($invoices);
        }
        else {
            throw new NotFoundException(__('Rechnung nicht gefunden'));
        }
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
            }
            else {
                $this->Session->setFlash(__('The invoice could not be saved. Please, try again.'));
            }
        }
        $types = $this->Invoice->Type->find('list');
        $users = $this->Invoice->User->find('list');
        $this->set(compact('types', 'users'));
    }

    public function add() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->autoRender = false;

        $this->Invoice->create();
        if ($this->Invoice->save(array(
            'Invoice' => array(
                'user_id'     => $this->getUserId(),
                'type_name'   => $this->request->data['type_name'],
                'institution' => $this->request->data['institution'],
                'department'  => $this->request->data['department'],
                'postbox'     => $this->request->data['postbox'],
                'to_person'   => $this->request->data['to_person'],
                'street'      => $this->request->data['street'],
                'zip'         => $this->request->data['zip'],
                'location'    => $this->request->data['location']
            )
        ))
        ) {
            return json_encode($this->Invoice->findById($this->Invoice->getLastInsertID()));
        }
        else {
            return json_encode(array('message' => __('Fehler beim Speichern')));
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
        $this->Invoice->id = $id;
        if (!$this->Invoice->exists()) {
            throw new NotFoundException(__('Invalid invoice'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Invoice->save($this->request->data)) {
                $this->Session->setFlash(__('The invoice has been saved'));
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('The invoice could not be saved. Please, try again.'));
            }
        }
        else {
            $this->request->data   = $this->Invoice->read(null, $id);

            $related_courses_terms = $this->Invoice->query('
                SELECT Invoice.id,Booking.id,CoursesTerm.id,Schedule.display,Course.name,Category.name,Term.id,Term.name FROM invoices Invoice
                    LEFT OUTER JOIN bookings Booking ON (Invoice.id = Booking.invoice_id)
                    LEFT OUTER JOIN courses_terms CoursesTerm ON (Booking.courses_term_id = CoursesTerm.id)
                    LEFT OUTER JOIN courses Course ON (CoursesTerm.course_id = Course.id)
                    LEFT OUTER JOIN terms Term ON (CoursesTerm.term_id = Term.id)
                    LEFT OUTER JOIN categories Category ON (Course.category_id = Category.id)
                    LEFT OUTER JOIN schedules Schedule ON (CoursesTerm.schedule_name = Schedule.name)
                WHERE Invoice.id = ?
                    ORDER BY Term.id DESC,Course.name ASC
            ', array($id));

            $types = $this->Invoice->Type->find('list');
            $this->set(compact('types', 'related_courses_terms'));
        }
    }

    public function edit() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->autoRender = false;

        $this->Invoice->recursive = -1;
        if ($this->Invoice->updateAll(
            array(
                'Invoice.type_name'   => "'" . Sanitize::escape($this->request->data['type_name']) . "'",
                'Invoice.institution' => "'" . Sanitize::escape($this->request->data['institution']) . "'",
                'Invoice.department'  => "'" . Sanitize::escape($this->request->data['department']) . "'",
                'Invoice.postbox'     => "'" . Sanitize::escape($this->request->data['postbox']) . "'",
                'Invoice.to_person'   => "'" . Sanitize::escape($this->request->data['to_person']) . "'",
                'Invoice.street'      => "'" . Sanitize::escape($this->request->data['street']) . "'",
                'Invoice.zip'         => "'" . Sanitize::escape($this->request->data['zip']) . "'",
                'Invoice.location'    => "'" . Sanitize::escape($this->request->data['location']) . "'"
            ),
            array(
                'Invoice.user_id' => $this->getUserId(),
                'Invoice.id'      => intval($this->request->data['invoice_id'])
            )
        )
        ) {
            return json_encode($this->Invoice->findById($this->request->data['invoice_id']));
        }
        else {
            return json_encode(array('message' => __('Fehler beim Speichern')));
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

    public function delete() {
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        if (!$this->Invoice->deleteAll(
            array(
                'Invoice.id'      => $this->request->data['id'],
                'Invoice.user_id' => $this->getUserId()
            ),
            false
        )
        ) {
            throw new Exception(__('Die Rechnung konnte nicht gelöscht werden'));
        }
    }

}
