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
		'app.course',
		'app.category',
		'app.courses_term',
		'app.terms_user',
		'app.courses_terms_user',
		'app.s_terms_user'
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
