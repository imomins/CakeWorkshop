<?php
App::uses('Term', 'Model');

/**
 * Term Test Case
 *
 */
class TermTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.term',
		'app.courses_term',
		'app.course',
		'app.category',
		'app.schedule',
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
		$this->Term = ClassRegistry::init('Term');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Term);

		parent::tearDown();
	}

}
