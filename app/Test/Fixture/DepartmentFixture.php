<?php
/**
 * DepartmentFixture
 *
 */
class DepartmentFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'number' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'key' => 'unique'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'idx_unique_name' => array('column' => 'name', 'unique' => 1),
			'number_UNIQUE' => array('column' => 'number', 'unique' => 1)
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
			'number' => 1,
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'number' => 2,
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'number' => 3,
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'number' => 4,
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'number' => 5,
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'number' => 6,
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'number' => 7,
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'number' => 8,
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'number' => 9,
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'number' => 10,
			'name' => 'Lorem ipsum dolor sit amet'
		),
	);

}
