<?php
/**
 * DayFixture
 *
 */
class DayFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'courses_term_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'start_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'start_time' => array('type' => 'time', 'null' => false, 'default' => null, 'key' => 'index'),
		'end_time' => array('type' => 'time', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'unique_day' => array('column' => array('start_time', 'end_time', 'courses_term_id', 'start_date'), 'unique' => 1),
			'fk_courses_days_courses_terms1_idx' => array('column' => 'courses_term_id', 'unique' => 0)
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
			'courses_term_id' => '',
			'start_date' => '2013-05-13',
			'start_time' => '23:06:40',
			'end_time' => '23:06:40'
		),
		array(
			'id' => '',
			'courses_term_id' => '',
			'start_date' => '2013-05-13',
			'start_time' => '23:06:40',
			'end_time' => '23:06:40'
		),
		array(
			'id' => '',
			'courses_term_id' => '',
			'start_date' => '2013-05-13',
			'start_time' => '23:06:40',
			'end_time' => '23:06:40'
		),
		array(
			'id' => '',
			'courses_term_id' => '',
			'start_date' => '2013-05-13',
			'start_time' => '23:06:40',
			'end_time' => '23:06:40'
		),
		array(
			'id' => '',
			'courses_term_id' => '',
			'start_date' => '2013-05-13',
			'start_time' => '23:06:40',
			'end_time' => '23:06:40'
		),
		array(
			'id' => '',
			'courses_term_id' => '',
			'start_date' => '2013-05-13',
			'start_time' => '23:06:40',
			'end_time' => '23:06:40'
		),
		array(
			'id' => '',
			'courses_term_id' => '',
			'start_date' => '2013-05-13',
			'start_time' => '23:06:40',
			'end_time' => '23:06:40'
		),
		array(
			'id' => '',
			'courses_term_id' => '',
			'start_date' => '2013-05-13',
			'start_time' => '23:06:40',
			'end_time' => '23:06:40'
		),
		array(
			'id' => '',
			'courses_term_id' => '',
			'start_date' => '2013-05-13',
			'start_time' => '23:06:40',
			'end_time' => '23:06:40'
		),
		array(
			'id' => '',
			'courses_term_id' => '',
			'start_date' => '2013-05-13',
			'start_time' => '23:06:40',
			'end_time' => '23:06:40'
		),
	);

}
