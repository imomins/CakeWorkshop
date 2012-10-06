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
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'terms_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'courses_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'attendees' => array('type' => 'integer', 'null' => false, 'default' => null),
		'max' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_courses_terms_terms1_idx' => array('column' => 'terms_id', 'unique' => 0),
			'fk_courses_terms_courses1_idx' => array('column' => 'courses_id', 'unique' => 0)
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
			'id' => 1,
			'terms_id' => 1,
			'courses_id' => 1,
			'attendees' => 1,
			'max' => 1
		),
	);

}
