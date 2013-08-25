<?php
/**
 * AddressFixture

 */
class AddressFixture extends CakeTestFixture {

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id'              => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'user_id'         => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
        'type_name'       => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
        'institution'     => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
        'department'      => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
        'postbox'         => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
        'to_person'       => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
        'street'          => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
        'zip'             => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
        'location'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY'                => array('column' => 'id', 'unique' => 1),
            'fk_addresses_types_idx' => array('column' => 'type_name', 'unique' => 0),
            'fk_addresses_users_idx' => array('column' => 'user_id', 'unique' => 0)
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
            'id'          => '',
            'user_id'     => '',
            'type_name'   => 'Lorem ipsum dolor sit amet',
            'institution' => 'Lorem ipsum dolor sit amet',
            'department'  => 'Lorem ipsum dolor sit amet',
            'postbox'     => 'Lorem ipsum dolor sit amet',
            'to_person'   => 'Lorem ipsum dolor sit amet',
            'street'      => 'Lorem ipsum dolor sit amet',
            'zip'         => 'Lorem ip',
            'location'    => 'Lorem ipsum dolor sit amet'
        ),
        array(
            'id'          => '',
            'user_id'     => '',
            'type_name'   => 'Lorem ipsum dolor sit amet',
            'institution' => 'Lorem ipsum dolor sit amet',
            'department'  => 'Lorem ipsum dolor sit amet',
            'postbox'     => 'Lorem ipsum dolor sit amet',
            'to_person'   => 'Lorem ipsum dolor sit amet',
            'street'      => 'Lorem ipsum dolor sit amet',
            'zip'         => 'Lorem ip',
            'location'    => 'Lorem ipsum dolor sit amet'
        ),
        array(
            'id'          => '',
            'user_id'     => '',
            'type_name'   => 'Lorem ipsum dolor sit amet',
            'institution' => 'Lorem ipsum dolor sit amet',
            'department'  => 'Lorem ipsum dolor sit amet',
            'postbox'     => 'Lorem ipsum dolor sit amet',
            'to_person'   => 'Lorem ipsum dolor sit amet',
            'street'      => 'Lorem ipsum dolor sit amet',
            'zip'         => 'Lorem ip',
            'location'    => 'Lorem ipsum dolor sit amet'
        ),
        array(
            'id'          => '',
            'user_id'     => '',
            'type_name'   => 'Lorem ipsum dolor sit amet',
            'institution' => 'Lorem ipsum dolor sit amet',
            'department'  => 'Lorem ipsum dolor sit amet',
            'postbox'     => 'Lorem ipsum dolor sit amet',
            'to_person'   => 'Lorem ipsum dolor sit amet',
            'street'      => 'Lorem ipsum dolor sit amet',
            'zip'         => 'Lorem ip',
            'location'    => 'Lorem ipsum dolor sit amet'
        ),
        array(
            'id'          => '',
            'user_id'     => '',
            'type_name'   => 'Lorem ipsum dolor sit amet',
            'institution' => 'Lorem ipsum dolor sit amet',
            'department'  => 'Lorem ipsum dolor sit amet',
            'postbox'     => 'Lorem ipsum dolor sit amet',
            'to_person'   => 'Lorem ipsum dolor sit amet',
            'street'      => 'Lorem ipsum dolor sit amet',
            'zip'         => 'Lorem ip',
            'location'    => 'Lorem ipsum dolor sit amet'
        ),
        array(
            'id'          => '',
            'user_id'     => '',
            'type_name'   => 'Lorem ipsum dolor sit amet',
            'institution' => 'Lorem ipsum dolor sit amet',
            'department'  => 'Lorem ipsum dolor sit amet',
            'postbox'     => 'Lorem ipsum dolor sit amet',
            'to_person'   => 'Lorem ipsum dolor sit amet',
            'street'      => 'Lorem ipsum dolor sit amet',
            'zip'         => 'Lorem ip',
            'location'    => 'Lorem ipsum dolor sit amet'
        ),
        array(
            'id'          => '',
            'user_id'     => '',
            'type_name'   => 'Lorem ipsum dolor sit amet',
            'institution' => 'Lorem ipsum dolor sit amet',
            'department'  => 'Lorem ipsum dolor sit amet',
            'postbox'     => 'Lorem ipsum dolor sit amet',
            'to_person'   => 'Lorem ipsum dolor sit amet',
            'street'      => 'Lorem ipsum dolor sit amet',
            'zip'         => 'Lorem ip',
            'location'    => 'Lorem ipsum dolor sit amet'
        ),
        array(
            'id'          => '',
            'user_id'     => '',
            'type_name'   => 'Lorem ipsum dolor sit amet',
            'institution' => 'Lorem ipsum dolor sit amet',
            'department'  => 'Lorem ipsum dolor sit amet',
            'postbox'     => 'Lorem ipsum dolor sit amet',
            'to_person'   => 'Lorem ipsum dolor sit amet',
            'street'      => 'Lorem ipsum dolor sit amet',
            'zip'         => 'Lorem ip',
            'location'    => 'Lorem ipsum dolor sit amet'
        ),
        array(
            'id'          => '',
            'user_id'     => '',
            'type_name'   => 'Lorem ipsum dolor sit amet',
            'institution' => 'Lorem ipsum dolor sit amet',
            'department'  => 'Lorem ipsum dolor sit amet',
            'postbox'     => 'Lorem ipsum dolor sit amet',
            'to_person'   => 'Lorem ipsum dolor sit amet',
            'street'      => 'Lorem ipsum dolor sit amet',
            'zip'         => 'Lorem ip',
            'location'    => 'Lorem ipsum dolor sit amet'
        ),
        array(
            'id'          => '',
            'user_id'     => '',
            'type_name'   => 'Lorem ipsum dolor sit amet',
            'institution' => 'Lorem ipsum dolor sit amet',
            'department'  => 'Lorem ipsum dolor sit amet',
            'postbox'     => 'Lorem ipsum dolor sit amet',
            'to_person'   => 'Lorem ipsum dolor sit amet',
            'street'      => 'Lorem ipsum dolor sit amet',
            'zip'         => 'Lorem ip',
            'location'    => 'Lorem ipsum dolor sit amet'
        ),
    );

}
