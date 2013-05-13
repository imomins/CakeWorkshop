<?php
/**
 * CategoryFixture
 *
 */
class CategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name_UNIQUE' => array('column' => 'name', 'unique' => 1)
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
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => '',
			'name' => 'Lorem ipsum dolor sit amet'
		),
	);

}
