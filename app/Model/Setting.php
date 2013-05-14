<?php
App::uses('AppModel', 'Model');
/**
 * Setting Model

 */
class Setting extends AppModel {

    /**
     * Primary key field
     *
     * @var string
     */
    public $primaryKey = 'key';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * Create hash table with all keys, like:
     * array(
     *    'current_term' => array(
     *        'key' => 'current_term',
     *       'title' => 'Aktuelles Semester',
     *        'value' => null
     *    )
     *
     * @return array
     */
    public function findHash() {
        $settings = $this->find('all');
        $hash     = array();
        foreach ($settings as $setting) {
            $hash[$setting['Setting']['key']] = $setting['Setting'];
        }
        return $hash;
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'key'   => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'title' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'value' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );
}
