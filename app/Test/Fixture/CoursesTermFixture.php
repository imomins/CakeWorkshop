<?php
/**
 * CoursesTermFixture
 *
 */
class CoursesTermFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'term_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'course_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'schedule_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'attendees' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'max' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'location' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1000, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'locked' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'course_UNIQUE' => array('column' => array('term_id', 'course_id', 'schedule_name'), 'unique' => 1),
			'fk_courses_terms_terms1_idx' => array('column' => 'term_id', 'unique' => 0),
			'fk_courses_terms_courses1_idx' => array('column' => 'course_id', 'unique' => 0),
			'fk_courses_terms_schedules1_idx' => array('column' => 'schedule_name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '',
			'term_id' => '',
			'course_id' => '',
			'schedule_name' => 'Lorem ipsum dolor sit amet',
			'attendees' => 1,
			'max' => 1,
			'location' => 'Lorem ipsum dolor sit amet',
			'locked' => 1
		),
		array(
			'id' => '',
			'term_id' => '',
			'course_id' => '',
			'schedule_name' => 'Lorem ipsum dolor sit amet',
			'attendees' => 2,
			'max' => 2,
			'location' => 'Lorem ipsum dolor sit amet',
			'locked' => 1
		),
		array(
			'id' => '',
			'term_id' => '',
			'course_id' => '',
			'schedule_name' => 'Lorem ipsum dolor sit amet',
			'attendees' => 3,
			'max' => 3,
			'location' => 'Lorem ipsum dolor sit amet',
			'locked' => 1
		),
		array(
			'id' => '',
			'term_id' => '',
			'course_id' => '',
			'schedule_name' => 'Lorem ipsum dolor sit amet',
			'attendees' => 4,
			'max' => 4,
			'location' => 'Lorem ipsum dolor sit amet',
			'locked' => 1
		),
		array(
			'id' => '',
			'term_id' => '',
			'course_id' => '',
			'schedule_name' => 'Lorem ipsum dolor sit amet',
			'attendees' => 5,
			'max' => 5,
			'location' => 'Lorem ipsum dolor sit amet',
			'locked' => 1
		),
		array(
			'id' => '',
			'term_id' => '',
			'course_id' => '',
			'schedule_name' => 'Lorem ipsum dolor sit amet',
			'attendees' => 6,
			'max' => 6,
			'location' => 'Lorem ipsum dolor sit amet',
			'locked' => 1
		),
		array(
			'id' => '',
			'term_id' => '',
			'course_id' => '',
			'schedule_name' => 'Lorem ipsum dolor sit amet',
			'attendees' => 7,
			'max' => 7,
			'location' => 'Lorem ipsum dolor sit amet',
			'locked' => 1
		),
		array(
			'id' => '',
			'term_id' => '',
			'course_id' => '',
			'schedule_name' => 'Lorem ipsum dolor sit amet',
			'attendees' => 8,
			'max' => 8,
			'location' => 'Lorem ipsum dolor sit amet',
			'locked' => 1
		),
		array(
			'id' => '',
			'term_id' => '',
			'course_id' => '',
			'schedule_name' => 'Lorem ipsum dolor sit amet',
			'attendees' => 9,
			'max' => 9,
			'location' => 'Lorem ipsum dolor sit amet',
			'locked' => 1
		),
		array(
			'id' => '',
			'term_id' => '',
			'course_id' => '',
			'schedule_name' => 'Lorem ipsum dolor sit amet',
			'attendees' => 10,
			'max' => 10,
			'location' => 'Lorem ipsum dolor sit amet',
			'locked' => 1
		),
	);

}
