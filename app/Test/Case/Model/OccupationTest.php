<?php
App::uses('Occupation', 'Model');

/**
 * Occupation Test Case
 *
 */
class OccupationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.occupation',
		'app.user',
		'app.gender',
		'app.department',
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
		$this->Occupation = ClassRegistry::init('Occupation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Occupation);

		parent::tearDown();
	}

}
