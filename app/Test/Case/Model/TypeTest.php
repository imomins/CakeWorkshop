<?php
App::uses('Type', 'Model');

/**
 * Type Test Case
 *
 */
class TypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.type',
		'app.invoice',
		'app.courses_terms_user',
		'app.user',
		'app.title',
		'app.gender',
		'app.department',
		'app.occupation',
		'app.group',
		'app.courses_term',
		'app.term',
		'app.course',
		'app.category',
		'app.terms_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Type = ClassRegistry::init('Type');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Type);

		parent::tearDown();
	}

}
