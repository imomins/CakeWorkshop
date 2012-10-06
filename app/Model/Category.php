<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Course $Course
 */
class Category extends AppModel {

    var $actsAs = array('Containable');

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

    public function findGroupedByCategory($params = null) {
        $conditions = array();

        // The conditions
        if ($params !== null) {
            // Limit to a certain term
            if (isset($params['Term']['id'])) {
                $conditions = array('CoursesTerm.term_id' => $params['Term']['id']);
            }
            // Exclude certain trainings which a user already booked
            if (isset($params['CoursesTerm'])) {
                $conditions = array('NOT' => array('CoursesTerm.id' => $params['CoursesTerm']));
            }
        }

        return $this->find('all',
            array(
                'contain' => array(
                    'Course' => array(
                        'order' => 'Course.label ASC',
                        'fields' => array('Course.label'),
                        'CoursesTerm' => array(
                            'conditions' => $conditions,
                            'fields' => array('CoursesTerm.attendees', 'CoursesTerm.max'),
                            'Term' => array(
                                'fields' => array('Term.id', 'Term.name'),
                            ),
                            'Day'
                        )
                    )
                )
            )
        );
    }

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
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

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'category_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
