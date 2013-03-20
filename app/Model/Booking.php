<?php
App::uses('AppModel', 'Model');
/**
 * Booking Model
 *
 * @property User $User
 * @property CoursesTerm $CoursesTerm
 * @property Invoice $Invoice
 */
class Booking extends AppModel {

    var $actsAs = array('Containable');

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'Course.name';

    public function findBookingsByUserId($userId, $termId = null) {
        /*
            SELECT Booking.id,Category.name,Course.name,Term.name,CoursesTerm.attendees,CoursesTerm.max,Invoice.name
            FROM bookings AS Booking
            LEFT JOIN courses_terms AS CoursesTerm ON Booking.courses_term_id = CoursesTerm.id
            LEFT JOIN terms AS Term ON CoursesTerm.term_id = Term.id
            LEFT JOIN courses AS Course ON CoursesTerm.course_id = Course.id
            LEFT JOIN categories AS Category ON Course.category_id = Category.id
            LEFT JOIN users AS User ON Booking.user_id = User.id
            LEFT JOIN invoices AS Invoice ON Booking.invoice_id = Invoice.id
            WHERE Booking.user_id = 1
            ORDER BY Category.Name ASC;
         */

        $query = <<<EOT
            SELECT Booking.id,Day.start_date,Day.start_time,Day.end_time,Category.name,Course.name,Term.name,CoursesTerm.attendees,CoursesTerm.max,Invoice.name
            FROM bookings AS Booking
            LEFT OUTER JOIN courses_terms AS CoursesTerm ON Booking.courses_term_id = CoursesTerm.id
            LEFT OUTER JOIN terms AS Term ON CoursesTerm.term_id = Term.id
            LEFT OUTER JOIN courses AS Course ON CoursesTerm.course_id = Course.id
            LEFT OUTER JOIN categories AS Category ON Course.category_id = Category.id
            LEFT OUTER JOIN users AS User ON Booking.user_id = User.id
            LEFT OUTER JOIN invoices AS Invoice ON Booking.invoice_id = Invoice.id
            LEFT OUTER JOIN days AS Day ON CoursesTerm.id = Day.courses_term_id
            WHERE Booking.user_id = 1
            ORDER BY Category.Name ASC;
EOT;

        return $this->query($query);


        return $this->find('all', array(
            'joins' => array(
                array(
                    'table' => 'courses_terms',
                    'alias' => 'CoursesTerm',
                    'type' => 'LEFT',
                    'conditions' => array('Booking.courses_term_id = CoursesTerm.id')
                ),
                array(
                    'table' => 'terms',
                    'alias' => 'Term',
                    'type' => 'LEFT',
                    'conditions' => array('CoursesTerm.term_id = Term.id')
                ),
                array(
                    'table' => 'courses',
                    'alias' => 'Course',
                    'type' => 'LEFT',
                    'conditions' => array('CoursesTerm.course_id = Course.id')
                ),
                array(
                    'table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'LEFT',
                    'conditions' => array('Course.category_id = Category.id')
                ),
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'LEFT',
                    'conditions' => array('Booking.user_id = User.id')
                ),
                array(
                    'table' => 'invoices',
                    'alias' => 'Invoice',
                    'type' => 'LEFT',
                    'conditions' => array('Booking.invoice_id = Invoice.id')
                ),
            )
        ));

        return $this->find('all', array(
            'conditions' => array('Booking.user_id' => $userId),
            'order' => array('Booking.created DESC'),
            'contain' => array(
                'Invoice' => array(
                    'fields' => array('Invoice.name')
                ),
                'CoursesTerm' => array(
                    'conditions' => ($termId !== null) ? array('CoursesTerm.term_id' => $termId) : array(),
                    'Course' => array('fields' => array('Course.name')),
                    'Term' => array('fields' => array('Term.name')),
                    'Day'
                )
            )
        ));
    }

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Bitte einen Teilnehmer eingeben',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'commitment' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'completed' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'certificate' => array(
			'boolean' => array(
				'rule' => array('boolean'),
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'Invoice' => array(
            'className' => 'Invoice',
            'foreignKey' => 'invoice_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
		'CoursesTerm' => array(
			'className' => 'CoursesTerm',
			'foreignKey' => 'courses_term_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'Invoice' => array(
            'className' => 'Invoice',
            'foreignKey' => 'invoice_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
	);

}
