<?php
App::uses('Day', 'Model');

/**
 * Day Test Case
 *
 */
class DayTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.day',
		'app.courses_term',
		'app.term',
		'app.course',
		'app.category',
		'app.user',
		'app.gender',
		'app.department',
		'app.occupation',
		'app.group',
		'app.invoice',
		'app.type',
		'app.booking'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Day = ClassRegistry::init('Day');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Day);

		parent::tearDown();
	}

}
