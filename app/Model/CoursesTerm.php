<?php
App::uses('AppModel', 'Model');
/**
 * CoursesTerm Model
 *
 * @property Term $Term
 * @property Course $Course
 * @property User $User
 * @property Schedule $Schedule
 */
class CoursesTerm extends AppModel {

    public function getCoursesList() {
        // Changing the courses label
        $coursesTerms = $this->User->CoursesTerm->find('all', array(
            'fields'  => array('CoursesTerm.id'),
            'contain' => array(
                'Course' => array(
                    'fields' => array('Course.name')
                ),
                'Term'   => array(
                    'fields' => array('Term.name')
                )
            )
        ));
        $coursesTerms = Set::combine($coursesTerms, '{n}.CoursesTerm.id', array('{0} ({1})', '{n}.Course.name', '{n}.Term.name'));

        return $coursesTerms;
    }

    /**
     * Loops awfully inefficient, but the query is ok
     * and there is a lot of stuff to set for the view.
     * And caching can be done at any time.
     *
     * @param $param
     * @return array
     */
    public function findCoursesTermGroupedByCategoryWithBookingStateName($param) {
        $query = "
            SELECT
              (SELECT bookings.booking_state_name FROM bookings WHERE bookings.courses_term_id = courses_terms.id AND bookings.user_id = ?) booking_state_name,
              categories.id,categories.name,
              courses.id, courses.name,
              courses_terms.id, courses_terms.attendees,courses_terms.max,courses_terms.locked,
              terms.name,
              DATE_FORMAT(days.start_date, ' %d.%m.%Y') start_date, TIME_FORMAT(days.start_time, '%H:%m') start_time,TIME_FORMAT(days.end_time, '%H:%m') end_time
            FROM
                categories
                LEFT OUTER JOIN courses ON (categories.id = courses.category_id)
                LEFT OUTER JOIN courses_terms ON (courses.id = courses_terms.course_id)
                LEFT OUTER JOIN terms ON (courses_terms.term_id = terms.id)
                LEFT OUTER JOIN days ON (courses_terms.id = days.courses_term_id)
            WHERE
                terms.id = (SELECT value FROM settings WHERE `key` = 'current_term')
            ORDER BY
                categories.name ASC, courses.name ASC
        ";

        $editable = (isset($param['Editable']) ? $param['Editable'] : false);
        $rows     = $this->query($query, array($param['User']['id']));

        $categories = array();
        foreach ($rows as $row) {
            // Parent Categories->id
            if (!isset($categories[$row['categories']['id']])) {
                $categories[$row['categories']['id']]['Category']               = $row['categories'];
                $categories[$row['categories']['id']]['Category']['isEditable'] = $editable;
            }
            // Categories->Courses->id
            if (!isset($categories[$row['categories']['id']]['Category']['CoursesTerm'][$row['courses_terms']['id']])) {
                $locked = intval($row['courses_terms']['locked']) === 1;

                $categories[$row['categories']['id']]['Category']['CoursesTerm'][$row['courses_terms']['id']] = array(
                    'id'             => $row['courses_terms']['id'],
                    'isEditable'     => $editable,
                    'locked'         => $locked,
                    'Course'         => array(
                        'id'   => $row['courses']['id'],
                        'name' => $row['courses']['name'],
                    ),
                    'Booking'        => array(
                        'allowSubscribe'     => !$locked && !in_array($row[0]['booking_state_name'], array('admin_unsubscribed', 'confirmed', 'unconfirmed'), true),
                        'allowUnsubscribe'   => !$locked && !in_array($row[0]['booking_state_name'], array('admin_unsubscribed', null, 'self_unsubscribed'), true),
                        'booking_state_name' => $row[0]['booking_state_name'],
                        'isSubscribed'       => (($row[0]['booking_state_name'] === 'unconfirmed') || ($row[0]['booking_state_name'] === 'confirmed')),
                        'isConfirmed'        => $row[0]['booking_state_name'] === 'confirmed',
                        'adminUnsubscribed'  => $row[0]['booking_state_name'] === 'admin_unsubscribed',
                    ),
                    'Term'           => array('name' => $row['terms']['name']),
                    'attendees'      => $row['courses_terms']['attendees'],
                    'max'            => $row['courses_terms']['max'],
                    'lockedClass'    => $locked ? 'error' : '',
                    'confirmedClass' => ($row[0]['booking_state_name'] === 'confirmed') ? 'success' : '',
                    'errorClass'     => ($row['courses_terms']['attendees'] > $row['courses_terms']['max']) ? 'error' : '',
                    'booking_state'  => ($row[0]['booking_state_name'] !== null) ? $row[0]['booking_state_name'] : '',
                    'days'           => array()
                );

                // LEFT OUTER JOIN on days, don't take not yet set days
                if ($row[0]['start_date'] !== null) {
                    array_push(
                        $categories[$row['categories']['id']]['Category']['CoursesTerm'][$row['courses_terms']['id']]['days'],
                        array(
                            'start_date' => $row[0]['start_date'],
                            'start_time' => $row[0]['start_time'],
                            'end_time'   => $row[0]['end_time']
                        )
                    );
                }
            }
            // Add new days
            else {
                array_push(
                    $categories[$row['categories']['id']]['Category']['CoursesTerm'][$row['courses_terms']['id']]['days'],
                    array(
                        'start_date' => $row[0]['start_date'],
                        'start_time' => $row[0]['start_time'],
                        'end_time'   => $row[0]['end_time']
                    ));
            }
        }

        // Convert hashed Category and CoursesTerm to flat
        // arrays and set stuff for the view template.
        $categories_array = array();
        foreach ($categories as $category) {
            $coursesTerms                    = array();
            $category['Category']['isEmpty'] = sizeof($category['Category']['CoursesTerm']) === 0;
            foreach ($category['Category']['CoursesTerm'] as $coursesTerm) {
                array_push($coursesTerms, $coursesTerm);
            }
            $category['Category']['CoursesTerm'] = $coursesTerms;
            array_push($categories_array, $category);
        }
        return $categories_array;
    }

    /**
     * Returns the courses optionally for a certain semester and or courses which a
     * user hasn't booked yet.
     * Nicely formatted the full query:
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
                ' AND CoursesTerm.id NOT IN (' .
                    '   SELECT BookingsSubquery.courses_term_id' .
                    '   	FROM bookings AS BookingsSubquery' .
                    '	    WHERE BookingsSubquery.user_id = ?' .
                    ' )' .
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
            ' SELECT Term.name,Course.name,Category.name,Category.id,CoursesTerm.id,Day.start_date,Day.start_time,Day.end_time,CoursesTerm.attendees,CoursesTerm.max' .
                ' FROM courses_terms AS CoursesTerm' .
                '	LEFT JOIN terms AS Term ON CoursesTerm.term_id = Term.id' .
                '	LEFT JOIN courses AS Course ON CoursesTerm.course_id = Course.id' .
                '	LEFT JOIN categories AS Category ON Course.category_id = Category.id' .
                '	LEFT JOIN days AS Day ON CoursesTerm.id = Day.courses_term_id' .
                ' WHERE 1=1' .
                $user_condition .
                $term_condition,
            $params
        );

        // Prepare to group by 'Category.id'
        $coursesByCategory = array();
        foreach ($coursesTerm as $course) {
            $coursesByCategory[$course['Category']['id']] = array(
                'Category' => $course['Category'],
                'Course'   => array()
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
        foreach ($coursesTerm as $course) {
            $category_id    = $course['Category']['id'];
            $course_term_id = $course['CoursesTerm']['id'];

            // Category is the parent key, we don't need this twice.
            unset($course['Category']);

            if (!isset($coursesByCategory[$category_id]['Course'][$course_term_id])) {
                // Push actual new training for a term into the array.
                $coursesByCategory[$category_id]['Course'] = array($course_term_id => $course);
                $day                                       = $coursesByCategory[$category_id]['Course'][$course_term_id]['Day'];
            }
            else {
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
        'term_id'   => array(
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
        'max'       => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'locked'    => array(
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
        'Term'     => array(
            'className'  => 'Term',
            'foreignKey' => 'term_id',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        ),
        'Course'   => array(
            'className'  => 'Course',
            'foreignKey' => 'course_id',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        ),
        'Schedule' => array(
            'className'  => 'Schedule',
            'foreignKey' => 'schedule_name',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        )
    );

    public $hasMany = array(
        'Day'     => array(
            'className'    => 'Day',
            'foreignKey'   => 'courses_term_id',
            'dependent'    => true,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        ),
        'Booking' => array(
            'className'    => 'Booking',
            'foreignKey'   => 'courses_term_id',
            'dependent'    => true,
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

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'User' => array(
            'className'             => 'User',
            'joinTable'             => 'bookings',
            'foreignKey'            => 'courses_term_id',
            'associationForeignKey' => 'user_id',
            'unique'                => 'keepExisting',
            'conditions'            => '',
            'fields'                => '',
            'order'                 => '',
            'limit'                 => '',
            'offset'                => '',
            'finderQuery'           => '',
            'deleteQuery'           => '',
            'insertQuery'           => ''
        )
    );

}
