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
		'app.booking_state'
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
