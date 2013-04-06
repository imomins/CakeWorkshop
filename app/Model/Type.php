<?php
App::uses('AppModel', 'Model');
/**
 * Type Model
 *
 * @property Invoice $Invoice
 */
class Type extends AppModel {

    public $displayField = 'display';

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Invoice' => array(
            'className'    => 'Invoice',
            'foreignKey'   => 'type_name',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        )
    );

}
