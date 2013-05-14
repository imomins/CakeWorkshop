<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Course $Course
 */
class Category extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    public function findCoursesGroupedByCategory($params = null) {
        $query = "
            SELECT
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
            WHERE terms.id = (SELECT value FROM settings WHERE `key` = 'current_term')
                ORDER BY categories.name ASC, courses.name ASC";

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
