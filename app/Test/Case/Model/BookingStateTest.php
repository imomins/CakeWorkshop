<?php
App::uses('BookingState', 'Model');

/**
 * BookingState Test Case
 *
 */
class BookingStateTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.booking_state',
		'app.booking',
		'app.user',
		'app.gender',
		'app.department',
		'app.occupation',
		'app.group',
		'app.address',
		'app.type',
		'app.courses_term',
		'app.term',
		'app.course',
		'app.category',
		'app.schedule',
		'app.day',
		'app.attendance_state'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BookingState = ClassRegistry::init('BookingState');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BookingState);

		parent::tearDown();
	}

}
