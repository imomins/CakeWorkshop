<?php
App::uses('AppModel', 'Model');
/**
 * Course Model
 *
 * @property Category $Category
 * @property Term $Term
 * @property TermsUser $TermsUser
 */
class Course extends AppModel {

    var $actsAs = array('Containable');

    public $displayField = 'label';

    public function beforeSave($options = array()) {
        // This label is used in drop downs and stuff.
        // Using virtualFields was a pain, don't use that.

        $label = '';
        $valid = false;

        if (!empty($this->data['Course']['name'])) {
            $label = $label . $this->data['Course']['name'];
            $valid = true;
        }
        if (!empty($this->data['Course']['code'])) {
            $label = $label . ' (' . $this->data['Course']['code'] . ')';
        }

        // We add a label in the form "<name> (<code>)".
        $this->data['Course']['label'] = $label;

        return $valid;
    }

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Term' => array(
			'className' => 'Term',
			'joinTable' => 'courses_terms',
			'foreignKey' => 'course_id',
			'associationForeignKey' => 'term_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

    public $hasMany = array(
        'CoursesTerm' => array(
            'className' => 'CoursesTerm',
            'foreignKey' => 'course_id',
            'dependent' => true,
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
