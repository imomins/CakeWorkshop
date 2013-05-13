<?php
App::uses('Schedule', 'Model');

/**
 * Schedule Test Case
 *
 */
class ScheduleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.schedule',
		'app.courses_term',
		'app.term',
		'app.course',
		'app.category',
		'app.day',
		'app.booking',
		'app.address',
		'app.type',
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
		$this->Schedule = ClassRegistry::init('Schedule');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Schedule);

		parent::tearDown();
	}

}
