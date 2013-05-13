<?php
/**
 * BookingFixture
 *
 */
class BookingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'address_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'courses_term_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'booking_state_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'attendance_state_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'certificate' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'unsubscribed_at' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'idx_unique_booking' => array('column' => array('user_id', 'courses_term_id'), 'unique' => 1),
			'fk_bookings_users_idx' => array('column' => 'user_id', 'unique' => 0),
			'fk_bookings_courses_term_idx' => array('column' => 'courses_term_id', 'unique' => 0),
			'fk_bookings_statuses1_idx' => array('column' => 'booking_state_name', 'unique' => 0),
			'fk_bookings_attendance_states1_idx' => array('column' => 'attendance_state_name', 'unique' => 0),
			'fk_bookings_addresses1_idx' => array('column' => 'address_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '',
			'user_id' => '',
			'address_id' => '',
			'courses_term_id' => '',
			'booking_state_name' => 'Lorem ipsum dolor sit amet',
			'attendance_state_name' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'certificate' => 1,
			'unsubscribed_at' => '2013-05-13 23:06:38',
			'created' => '2013-05-13 23:06:38',
			'updated' => '2013-05-13 23:06:38'
		),
		array(
			'id' => '',
			'user_id' => '',
			'address_id' => '',
			'courses_term_id' => '',
			'booking_state_name' => 'Lorem ipsum dolor sit amet',
			'attendance_state_name' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'certificate' => 1,
			'unsubscribed_at' => '2013-05-13 23:06:38',
			'created' => '2013-05-13 23:06:38',
			'updated' => '2013-05-13 23:06:38'
		),
		array(
			'id' => '',
			'user_id' => '',
			'address_id' => '',
			'courses_term_id' => '',
			'booking_state_name' => 'Lorem ipsum dolor sit amet',
			'attendance_state_name' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'certificate' => 1,
			'unsubscribed_at' => '2013-05-13 23:06:38',
			'created' => '2013-05-13 23:06:38',
			'updated' => '2013-05-13 23:06:38'
		),
		array(
			'id' => '',
			'user_id' => '',
			'address_id' => '',
			'courses_term_id' => '',
			'booking_state_name' => 'Lorem ipsum dolor sit amet',
			'attendance_state_name' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'certificate' => 1,
			'unsubscribed_at' => '2013-05-13 23:06:38',
			'created' => '2013-05-13 23:06:38',
			'updated' => '2013-05-13 23:06:38'
		),
		array(
			'id' => '',
			'user_id' => '',
			'address_id' => '',
			'courses_term_id' => '',
			'booking_state_name' => 'Lorem ipsum dolor sit amet',
			'attendance_state_name' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'certificate' => 1,
			'unsubscribed_at' => '2013-05-13 23:06:38',
			'created' => '2013-05-13 23:06:38',
			'updated' => '2013-05-13 23:06:38'
		),
		array(
			'id' => '',
			'user_id' => '',
			'address_id' => '',
			'courses_term_id' => '',
			'booking_state_name' => 'Lorem ipsum dolor sit amet',
			'attendance_state_name' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'certificate' => 1,
			'unsubscribed_at' => '2013-05-13 23:06:38',
			'created' => '2013-05-13 23:06:38',
			'updated' => '2013-05-13 23:06:38'
		),
		array(
			'id' => '',
			'user_id' => '',
			'address_id' => '',
			'courses_term_id' => '',
			'booking_state_name' => 'Lorem ipsum dolor sit amet',
			'attendance_state_name' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'certificate' => 1,
			'unsubscribed_at' => '2013-05-13 23:06:38',
			'created' => '2013-05-13 23:06:38',
			'updated' => '2013-05-13 23:06:38'
		),
		array(
			'id' => '',
			'user_id' => '',
			'address_id' => '',
			'courses_term_id' => '',
			'booking_state_name' => 'Lorem ipsum dolor sit amet',
			'attendance_state_name' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'certificate' => 1,
			'unsubscribed_at' => '2013-05-13 23:06:38',
			'created' => '2013-05-13 23:06:38',
			'updated' => '2013-05-13 23:06:38'
		),
		array(
			'id' => '',
			'user_id' => '',
			'address_id' => '',
			'courses_term_id' => '',
			'booking_state_name' => 'Lorem ipsum dolor sit amet',
			'attendance_state_name' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'certificate' => 1,
			'unsubscribed_at' => '2013-05-13 23:06:38',
			'created' => '2013-05-13 23:06:38',
			'updated' => '2013-05-13 23:06:38'
		),
		array(
			'id' => '',
			'user_id' => '',
			'address_id' => '',
			'courses_term_id' => '',
			'booking_state_name' => 'Lorem ipsum dolor sit amet',
			'attendance_state_name' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'certificate' => 1,
			'unsubscribed_at' => '2013-05-13 23:06:38',
			'created' => '2013-05-13 23:06:38',
			'updated' => '2013-05-13 23:06:38'
		),
	);

}
