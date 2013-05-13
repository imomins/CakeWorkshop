<?php
App::uses('Booking', 'Model');

/**
 * Booking Test Case
 *
 */
class BookingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
		$this->Booking = ClassRegistry::init('Booking');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Booking);

		parent::tearDown();
	}

/**
 * testFindBookingsByIds method
 *
 * @return void
 */
	public function testFindBookingsByIds() {
	}

}
