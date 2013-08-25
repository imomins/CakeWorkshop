<?php
App::uses('AttendanceState', 'Model');

/**
 * AttendanceState Test Case

 */
class AttendanceStateTest extends CakeTestCase {

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.attendance_state',
        'app.booking',
        'app.user',
        'app.gender',
        'app.department',
        'app.occupation',
        'app.group',
        'app.address',
        'app.type',
        'app.courses_term',
        'app.term',
        'app.course',
        'app.category',
        'app.schedule',
        'app.day',
        'app.booking_state'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        $this->AttendanceState = ClassRegistry::init('AttendanceState');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->AttendanceState);

        parent::tearDown();
    }

}
