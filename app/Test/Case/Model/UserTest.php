<?php
App::uses('User', 'Model');

/**
 * User Test Case
 *
 */
class UserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user',
		'app.gender',
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
		$this->User = ClassRegistry::init('User');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->User);

		parent::tearDown();
	}

/**
 * testSearch method
 *
 * @return void
 */
	public function testSearch() {
	}

/**
 * testFindUserIdByEmail method
 *
 * @return void
 */
	public function testFindUserIdByEmail() {
	}

/**
 * testFindUserIdByHash method
 *
 * @return void
 */
	public function testFindUserIdByHash() {
	}

/**
 * testActivate method
 *
 * @return void
 */
	public function testActivate() {
	}

/**
 * testPassCompare method
 *
 * @return void
 */
	public function testPassCompare() {
	}

}
