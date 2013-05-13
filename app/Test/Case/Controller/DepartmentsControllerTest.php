<?php
App::uses('DepartmentsController', 'Controller');

/**
 * DepartmentsController Test Case
 *
 */
class DepartmentsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.department',
		'app.user',
		'app.gender',
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
 * testAdminIndex method
 *
 * @return void
 */
	public function testAdminIndex() {
	}

/**
 * testAdminView method
 *
 * @return void
 */
	public function testAdminView() {
	}

/**
 * testAdminAdd method
 *
 * @return void
 */
	public function testAdminAdd() {
	}

/**
 * testAdminEdit method
 *
 * @return void
 */
	public function testAdminEdit() {
	}

/**
 * testAdminDelete method
 *
 * @return void
 */
	public function testAdminDelete() {
	}

}
