<?php
App::uses('Category', 'Model');

/**
 * Category Test Case
 *
 */
class CategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.category',
		'app.course',
		'app.courses_term',
		'app.term',
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
		$this->Category = ClassRegistry::init('Category');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Category);

		parent::tearDown();
	}

/**
 * testFindCoursesGroupedByCategory method
 *
 * @return void
 */
	public function testFindCoursesGroupedByCategory() {
	}

}
