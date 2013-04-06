<?php
App::uses('AppModel', 'Model');
/**
 * Schedule Model

 */
class Schedule extends AppModel {

    /**
     * Primary key field
     *
     * @var string
     */
    public $primaryKey = 'name';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'display';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name'    => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'display' => array(
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

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'User' => array(
            'className'    => 'CoursesTerm',
            'foreignKey'   => 'schedule_name',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        )
    );

}
