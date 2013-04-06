<?php
App::uses('AppModel', 'Model');
/**
 * InvoiceType Model
 *
 * @property Invoice $Invoice
 */
class InvoiceType extends AppModel {

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Invoice' => array(
            'className'    => 'Invoice',
            'foreignKey'   => 'invoice_type_id',
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
