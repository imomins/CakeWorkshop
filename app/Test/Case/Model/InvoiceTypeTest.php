<?php
App::uses('InvoiceType', 'Model');

/**
 * InvoiceType Test Case
 *
 */
class InvoiceTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.invoice_type',
		'app.invoice'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InvoiceType = ClassRegistry::init('InvoiceType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InvoiceType);

		parent::tearDown();
	}

}
