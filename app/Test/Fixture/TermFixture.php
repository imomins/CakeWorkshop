<?php
/**
 * TermFixture
 *
 */
class TermFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'start' => array('type' => 'date', 'null' => false, 'default' => null),
		'end' => array('type' => 'date', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'idx_unique_term' => array('column' => 'name', 'unique' => 1)
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
			'name' => 'Lorem ipsum dolor sit amet',
			'start' => '2013-05-13',
			'end' => '2013-05-13'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet',
			'start' => '2013-05-13',
			'end' => '2013-05-13'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet',
			'start' => '2013-05-13',
			'end' => '2013-05-13'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet',
			'start' => '2013-05-13',
			'end' => '2013-05-13'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet',
			'start' => '2013-05-13',
			'end' => '2013-05-13'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet',
			'start' => '2013-05-13',
			'end' => '2013-05-13'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet',
			'start' => '2013-05-13',
			'end' => '2013-05-13'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet',
			'start' => '2013-05-13',
			'end' => '2013-05-13'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet',
			'start' => '2013-05-13',
			'end' => '2013-05-13'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet',
			'start' => '2013-05-13',
			'end' => '2013-05-13'
		),
	);

}
