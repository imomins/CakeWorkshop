<?php
App::uses('Gender', 'Model');

/**
 * Gender Test Case
 *
 */
class GenderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.gender',
		'app.user',
		'app.department',
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
		$this->Gender = ClassRegistry::init('Gender');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Gender);

		parent::tearDown();
	}

}
