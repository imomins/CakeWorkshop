<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * @property Setting $Setting
 */
class SettingsController extends AppController {

    public function admin_edit() {
        // Save list of key values
        if ($this->request->is('post')) {
            foreach ($this->request->data['Setting'] as $key => $value) {
                if (!$this->Setting->updateAll(
                    array(
                        'value' => "'" . Sanitize::clean(trim($value), array('encode' => false)) . "'"
                    ),
                    array('key' => $key)
                )
                ) {
                    throw new Exception(__('Fehler beim Speichern.'));
                }
            }
        }

        $title_for_layout = __('Einstellungen');

        $this->loadModel('Term');
        $terms = $this->Term->find('list', array('order' => array('id DESC')));
        $settings = $this->Setting->findHash();

        $this->set(compact('terms', 'title_for_layout', 'settings'));
    }

}