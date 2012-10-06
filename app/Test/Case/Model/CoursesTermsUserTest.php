<?php
App::uses('CoursesTermsUser', 'Model');

/**
 * CoursesTermsUser Test Case
 *
 */
class CoursesTermsUserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.courses_terms_user',
		'app.user',
		'app.courses_term',
		'app.terms',
		'app.courses',
		'app.invoice'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CoursesTermsUser = ClassRegistry::init('CoursesTermsUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CoursesTermsUser);

		parent::tearDown();
	}

}
