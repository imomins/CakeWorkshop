<?php
App::uses('AppModel', 'Model');
/**
 * Booking Model
 *
 * @property User $User
 * @property CoursesTerm $CoursesTerm
 * @property Invoice $Invoice
 * @property BookingState $BookingState
 * @property AttendanceState $AttendanceState
 * @property Occupation $Occupation
 */
class Booking extends AppModel {

    public function findCoursesTermGroupedByCategoryWithBookingStateName($param) {
        $query = '
            SELECT
              (SELECT bookings.booking_state_name FROM bookings WHERE bookings.courses_term_id = courses_terms.id AND bookings.user_id = ?) booking_state_name,
              categories.id,categories.name,
              courses.id, courses.name,
              courses_terms.id, courses_terms.attendees,courses_terms.max,
              terms.name,
              days.start_date,days.start_time,days.end_time
            FROM categories
                LEFT OUTER JOIN courses ON (categories.id = courses.category_id)
                LEFT OUTER JOIN courses_terms ON (courses.id = courses_terms.course_id)
                LEFT OUTER JOIN terms ON (courses_terms.term_id = terms.id)
                LEFT OUTER JOIN days ON (courses_terms.id = days.courses_term_id)
            WHERE terms.id = (SELECT id FROM terms ORDER BY id DESC LIMIT 1)
                ORDER BY categories.name ASC, courses.name ASC';

        $rows = $this->query($query, array($param['User']['id']));

        $categories = array();
        foreach ($rows as $row) {
            // Parent Categories->id
            if (!isset($categories[$row['categories']['id']])) {
                $categories[$row['categories']['id']]['Category'] = $row['categories'];
            }
            // Categories->Courses->id
            if (!isset($categories[$row['categories']['id']]['Category']['CoursesTerm'][$row['courses_terms']['id']])) {
                $categories[$row['categories']['id']]['Category']['CoursesTerm'][$row['courses_terms']['id']] = array(
                    'id'        => $row['courses_terms']['id'],
                    'Course'    => array(
                        'id'   => $row['courses']['id'],
                        'name' => $row['courses']['name'],
                    ),
                    'Booking'   => array('booking_state_name' => $row[0]['booking_state_name']),
                    'Term'      => array('name' => $row['terms']['name']),
                    'attendees' => $row['courses_terms']['attendees'],
                    'max'       => $row['courses_terms']['max'],
                    'days'      => array($row['days'])
                );
            }
            // Add new days
            else {
                array_push($categories[$row['categories']['id']]['Category']['CoursesTerm'][$row['courses_terms']['id']]['days'], $row['days']);
            }
        }
        return $categories;
    }

    public function findBookingsByUserId($userId, $termId = null) {
        /*
        $query = '
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
                ORDER BY Category.Name ASC';

        return $this->query($query);
        */

        return $this->find('all', array(
            'conditions' => array('Booking.user_id' => $userId),
            'order'      => array('Booking.created DESC'),
            'contain'    => array(
                'Invoice'     => array(
                    'fields' => array('Invoice.name')
                ),
                'CoursesTerm' => array(
                    'conditions' => ($termId !== null) ? array('CoursesTerm.term_id' => $termId) : array(),
                    'Course'     => array('fields' => array('Course.name')),
                    'Term'       => array('fields' => array('Term.name')),
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
        'user_id'               => array(
            'numeric' => array(
                'rule'    => array('numeric'),
                'message' => 'Bitte einen Teilnehmer eingeben',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'courses_term_id'       => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'certificate'           => array(
            'boolean' => array(
                'rule' => array('boolean'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'invoice_id'            => array(
            'numeric' => array(
                'rule'    => array('numeric'),
                'message' => 'Bitte geben Sie eine Rechnung an',
            ),
        ),
        'occupation_id'         => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'booking_state_name'    => array(
            'notempty' => array(
                'rule'    => array('notempty'),
                'message' => 'Der Buchungsstatus fehlt',
            ),
        ),
        'attendance_state_name' => array(),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User'            => array(
            'className'  => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        ),
        'Invoice'         => array(
            'className'  => 'Invoice',
            'foreignKey' => 'invoice_id',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        ),
        'CoursesTerm'     => array(
            'className'  => 'CoursesTerm',
            'foreignKey' => 'courses_term_id',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        ),
        'BookingState'    => array(
            'className'  => 'BookingState',
            'foreignKey' => 'booking_state_name',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        ),
        'AttendanceState' => array(
            'className'  => 'AttendanceState',
            'foreignKey' => 'attendance_state_name',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        ),
    );

}
