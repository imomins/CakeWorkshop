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

    public function findCoursesGroupedByCategory($params = null) {
        $query = '
            SELECT
              categories.id,categories.name,
              courses.id, courses.name,
              courses_terms.id, courses_terms.attendees,courses_terms.max,
              terms.name,
              days.start_date,days.start_time,days.end_time
            FROM categories LEFT OUTER
                JOIN courses ON (categories.id = courses.category_id) LEFT OUTER
                JOIN courses_terms ON (courses.id = courses_terms.course_id) LEFT OUTER
                JOIN terms ON (courses_terms.term_id = terms.id)
                JOIN days ON (courses_terms.id = days.courses_term_id)
            WHERE terms.id = (SELECT id FROM terms ORDER BY id DESC LIMIT 1)
        ';

        if (isset($params['Bookings'])) {
            $query .= 'AND courses_terms.id NOT IN (' . implode(',', $params['Bookings']) . ')';
        }
        $query .= 'ORDER BY categories.name ASC, courses.name ASC';

        $rows = $this->query($query);

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
                        'order'       => 'Course.name ASC',
                        'fields'      => array('Course.name'),
                        'CoursesTerm' => array(
                            'conditions' => $conditions,
                            'fields'     => array('CoursesTerm.attendees', 'CoursesTerm.max'),
                            'Term'       => array(
                                'fields' => array('Term.id', 'Term.name'),
                            ),
                            'Day'
                        )
                    )
                ),
                'order'   => array('Category.name ASC')
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
            'className'    => 'Course',
            'foreignKey'   => 'category_id',
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
