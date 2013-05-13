<?php
App::uses('AppModel', 'Model');
/**
 * Booking Model
 *
 * @property User $User
 * @property CoursesTerm $CoursesTerm
 * @property Address $Address
 * @property BookingState $BookingState
 * @property AttendanceState $AttendanceState
 * @property Occupation $Occupation
 */
class Booking extends AppModel {

    /**
     * Used mainly for the confirmation email to list the booked courses.
     *
     * @param $user_id
     * @param {Array} $ids Notice that this array must be sanitized.
     * @return mixed
     */
    public function findBookingsByIds($user_id, $ids) {
        $sql = <<<EOT
            SELECT
                CoursesTerm.id,
                Category.id id,Category.name name,
                Booking.id id,
                Course.name name,Term.name name,
                DATE_FORMAT(`Day`.start_date, ' %d.%m.%Y') start_date, TIME_FORMAT(`Day`.start_time, '%H:%m') start_time,TIME_FORMAT(`Day`.end_time, '%H:%m') end_time
            FROM bookings Booking
                LEFT OUTER JOIN courses_terms CoursesTerm ON (Booking.courses_term_id = CoursesTerm.id)
                LEFT OUTER JOIN courses Course ON (CoursesTerm.course_id = Course.id)
                LEFT OUTER JOIN terms Term ON (CoursesTerm.term_id = Term.id)
                LEFT OUTER JOIN days `Day` ON (CoursesTerm.id = `Day`.courses_term_id)
                LEFT OUTER JOIN categories Category ON (Course.category_id = Category.id)
EOT;
        $sql .= 'WHERE Booking.user_id = ? AND CoursesTerm.id IN (' . implode(',', $ids) . ')
                ORDER BY Category.name ASC, Booking.id ASC';

        $result      = $this->query($sql, array($user_id));
        $categories  = array();
        $category_id = null;

        foreach ($result as $row) {
            if (!isset($categories[$row['Category']['id']])) {
                $categories[$row['Category']['id']] = array(
                    'Category' => array('name' => $row['Category']['name'])
                );
            }
            if (!isset($categories[$row['Category']['id']]['Booking'][$row['Booking']['id']])) {
                $categories[$row['Category']['id']]['Booking'][$row['Booking']['id']] = array(
                    'id'          => $row['Booking']['id'],
                    'CoursesTerm' => $row['CoursesTerm'],
                    'Course'      => $row['Course'],
                    'Term'        => $row['Term'],
                    'Days'        => array(
                        array(
                            'start_date' => $row[0]['start_date'],
                            'start_time' => $row[0]['start_time'],
                            'end_time'   => $row[0]['end_time']
                        )
                    )
                );
            }
            else {
                // Exists, add additional days
                array_push($categories[$row['Category']['id']]['Booking'][$row['Booking']['id']]['Days'],
                    array(
                        'start_date' => $row[0]['start_date'],
                        'start_time' => $row[0]['start_time'],
                        'end_time'   => $row[0]['end_time']
                    )
                );
            }
        }

        return $categories;
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'user_id'            => array(
            'numeric' => array(
                'rule'    => array('numeric'),
                'message' => 'Bitte einen Teilnehmer eingeben',
            ),
        ),
        'courses_term_id'    => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'address_id'         => array(
            'numeric' => array(
                'rule'    => array('numeric'),
                'message' => 'Bitte geben Sie eine Rechnung an',
            ),
        ),
        'booking_state_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
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
        'Address'         => array(
            'className'  => 'Address',
            'foreignKey' => 'address_id',
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
