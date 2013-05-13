<?php
App::uses('CoursesTerm', 'Model');

/**
 * CoursesTerm Test Case
 *
 */
class CoursesTermTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.courses_term',
		'app.term',
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
		$this->CoursesTerm = ClassRegistry::init('CoursesTerm');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CoursesTerm);

		parent::tearDown();
	}

/**
 * testGetCoursesList method
 *
 * @return void
 */
	public function testGetCoursesList() {
	}

/**
 * testFindCoursesTermGroupedByCategoryWithBookingStateName method
 *
 * @return void
 */
	public function testFindCoursesTermGroupedByCategoryWithBookingStateName() {
	}

/**
 * testFindGroupedByCategory method
 *
 * @return void
 */
	public function testFindGroupedByCategory() {
	}

}
