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
		'app.terms',
		'app.courses',
		'app.user',
		'app.courses_terms_user'
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

}
