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
		'app.user'
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
