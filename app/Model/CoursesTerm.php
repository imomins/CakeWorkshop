<?php
App::uses('AppModel', 'Model');
/**
 * CoursesTerm Model
 *
 * @property Term $Term
 * @property Course $Course
 * @property User $User
 */
class CoursesTerm extends AppModel {

    var $actsAs = array('Containable');



    public function getCoursesList() {
        // Changing the courses label
        $coursesTerms = $this->User->CoursesTerm->find('all', array(
            'fields' => array('CoursesTerm.id'),
            'contain' => array(
                'Course' => array(
                    'fields' => array('Course.name')
                ),
                'Term' => array(
                    'fields' => array('Term.name')
                )
            )
        ));
        $coursesTerms = Set::combine($coursesTerms, '{n}.CoursesTerm.id', array('{0} - {1}', '{n}.Course.name', '{n}.Term.name'));

        return $coursesTerms;
    }

    /**
     * Returns the courses optionally for a certain semester and or courses which a
     * user hasn't booked yet.
     *
     * Nicely formatted the full query:
     *
     * SELECT Term.name,Course.name,Category.name,Category.id,CoursesTerm.id,CoursesTerm.start_date,CoursesTerm.start_time,CoursesTerm.end_time,CoursesTerm.attendees,CoursesTerm.max
     * FROM courses_terms AS CoursesTerm
     *     LEFT JOIN terms AS Term ON CoursesTerm.term_id = Term.id
     *     LEFT JOIN courses AS Course ON CoursesTerm.course_id = Course.id
     *     LEFT JOIN categories AS Category ON Course.category_id = Category.id
     * WHERE CoursesTerm.id NOT IN (
     *     SELECT BookingsSubquery.courses_term_id
     *     FROM bookings AS BookingsSubquery
     *     WHERE BookingsSubquery.user_id = ?
     * ) AND Term.id = ?
     * ORDER BY Category.id ASC, Course.name ASC;
     *
     * @param null $term_id
     * @param null $exclude_user_id
     * @return array
     */
    public function findGroupedByCategory($exclude_user_id = null, $term_id = null) {
        $this->recursive = -1;

        // Query parameter arguments
        $params = array();

        // This removes the courses for a semester
        // which a certain user already booked.
        $user_condition = '';
        if ($exclude_user_id !== null) {
            $user_condition =
                ' AND CoursesTerm.id NOT IN ('.
                '   SELECT BookingsSubquery.courses_term_id'.
                '   	FROM bookings AS BookingsSubquery'.
                '	    WHERE BookingsSubquery.user_id = ?'.
                ' )'.
                ' ORDER BY Category.id ASC, Course.name ASC;';
            array_push($params, $exclude_user_id);
        }
        // Reduces the query to a certain term.
        $term_condition = '';
        if ($term_id !== null) {
            $term_condition = (($term_id === null) ? '' : ' AND Term.id = ?');
            array_push($params, $term_id);
        }

        // Easier to make this query like this
        $coursesTerm = $this->query(
            ' SELECT Term.name,Course.name,Category.name,Category.id,CoursesTerm.id,Day.start_date,Day.start_time,Day.end_time,CoursesTerm.attendees,CoursesTerm.max'.
                ' FROM courses_terms AS CoursesTerm'.
                '	LEFT JOIN terms AS Term ON CoursesTerm.term_id = Term.id'.
                '	LEFT JOIN courses AS Course ON CoursesTerm.course_id = Course.id'.
                '	LEFT JOIN categories AS Category ON Course.category_id = Category.id'.
                '	LEFT JOIN days AS Day ON CoursesTerm.id = Day.courses_term_id'.
                ' WHERE 1=1'.
                $user_condition.
                $term_condition,
                $params
        );

        // Prepare to group by 'Category.id'
        $coursesByCategory = array();
        foreach($coursesTerm as $course) {
            $coursesByCategory[$course['Category']['id']] = array(
                'Category' => $course['Category'],
                'Course' => array()
            );
        }

        // This section gets super ugly, but we need to group the courses for a term by category
        // and merge all days for that course together which are separate rows in the result set:
        // --------------------------------------------------------------------------------------
        //        array(
        //            'Category.id' => array(
        //                'Category' => array('name' => 'Category.name', 'id' => 'Category.id'),
        //
        //                'Course' => array(
        //                    'CoursesTerm.id' => array(
        //                        'Term' => array('name' => 'Term.name'),
        //
        //                        'Course' => array('label' => 'Course.name'),
        //
        //                        'CoursesTerm' => array(
        //                            'id' => 'CoursesTerm.id',
        //                            'attendees' => 'CoursesTerm.attendees',
        //                            'max' => 'CoursesTerm.max',
        //                        ),
        //
        //                        'Day' => array(
        //                            array(
        //                                'start_date' => 'Day.start_date',
        //                                'start_time' => 'Day.start_time',
        //                                'end_time' => 'Day.end_time'
        //                            ),
        //                            array(
        //                                'start_date' => 'Day.start_date',
        //                                'start_time' => 'Day.start_time',
        //                                'end_time' => 'Day.end_time'
        //                            ),
        //                        )
        //
        //                    )
        //                )
        //            ),
        //            'Category.id' => array(
        //                ...
        //            ),
        //            ...
        //        );

        // Group the courses by category
        foreach($coursesTerm as $course) {
            $category_id = $course['Category']['id'];
            $course_term_id = $course['CoursesTerm']['id'];

            // Category is the parent key, we don't need this twice.
            unset($course['Category']);

            if (!isset($coursesByCategory[$category_id]['Course'][$course_term_id])) {
                // Push actual new training for a term into the array.
                $coursesByCategory[$category_id]['Course'] = array($course_term_id => $course);
                $day = $coursesByCategory[$category_id]['Course'][$course_term_id]['Day'];
            } else {
                // Only push additional days in.
                array_push($coursesByCategory[$category_id]['Course'][$course_term_id]['Day'], $course['Day']);
            }
        }

        return $coursesByCategory;
    }

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'term_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'course_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'attendees' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'max' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'Term' => array(
			'className' => 'Term',
			'foreignKey' => 'term_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    public $hasMany = array(
        'Day' => array(
            'className' => 'Day',
            'foreignKey' => 'courses_term_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Booking' => array(
            'className' => 'Booking',
            'foreignKey' => 'courses_term_id',
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

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User',
			'joinTable' => 'bookings',
			'foreignKey' => 'courses_term_id',
			'associationForeignKey' => 'user_id',
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

}
