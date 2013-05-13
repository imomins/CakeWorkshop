<?php
App::uses('Department', 'Model');

/**
 * Department Test Case
 *
 */
class DepartmentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.department',
		'app.user',
		'app.gender',
		'app.occupation',
		'app.group',
		'app.booking',
		'app.address',
		'app.type',
		'app.courses_term',
		'app.term',
		'app.course',
		'app.category',
		'app.schedule',
		'app.day',
		'app.booking_state',
		'app.attendance_state'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Department = ClassRegistry::init('Department');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Department);

		parent::tearDown();
	}

}
