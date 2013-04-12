<?php
App::uses('AppModel', 'Model');
/**
 * Day Model
 *
 * @property CoursesTerm $CoursesTerm
 */
class Day extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'courses_term_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'date'            => array(
            'date' => array(
                'rule' => array('date'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'start_time'      => array(
            'time' => array(
                'rule' => array('time'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'end_time'        => array(
            'time' => array(
                'rule' => array('time'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'CoursesTerm' => array(
            'className'  => 'CoursesTerm',
            'foreignKey' => 'courses_term_id',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        )
    );
}
