<?php
/**
 * CoursesTermsUserFixture
 *
 */
class CoursesTermsUserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'courses_term_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'invoice_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'commitment' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'completed' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'certificate' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_bookings_users1_idx' => array('column' => 'user_id', 'unique' => 0),
			'fk_courses_users_courses_terms1_idx' => array('column' => 'courses_term_id', 'unique' => 0),
			'fk_courses_terms_users_table11_idx' => array('column' => 'invoice_id', 'unique' => 0)
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
			'user_id' => 1,
			'courses_term_id' => 1,
			'invoice_id' => 1,
			'updated' => '2012-09-13 14:17:16',
			'commitment' => 1,
			'completed' => 1,
			'certificate' => 1,
			'created' => '2012-09-13 14:17:16'
		),
	);

}
