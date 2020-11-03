<?php

namespace AlvaroGomides\MelhorEnvio\Tests;

use PHPUnit\Framework\TestCase;
use AlvaroGomides\MelhorEnvio\Services\ProductsShipCalculator;
use AlvaroGomides\MelhorEnvio\Exceptions\MelhorEnvioException;

class ProductsShipCalculatorTest extends TestCase
{
    /** @test */
    public function the_request_can_add_a_item()
    {
    	$service = new ProductsShipCalculator();

    	$service->addItem(1,1,1,1,1,1);
    	$itemsCount = $service->listItems();
    	$this->assertCount(1, $itemsCount);
        
        $expected = [
	        'from' => [ 'postal_code' => ''],
	        'to' => [ 'postal_code' => ''],
	        'products' => [
	        	0 => [
		        	'id' => 1, 
		        	'width' => 1,
		        	'height' => 1,
		        	'length' => 1,
		        	'weight' => 1,
		        	'insurance_value' => 1,
		        	'quantity' => 1
		        ]
	        ],
	        'options' => [
	        	'receipt' => false, 
	        	'own_hand' => false
	        ],
	    ];

	    $result = $service->payload();
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function the_request_mounts_a_correct_payload()
    {
    	$service = new ProductsShipCalculator();

    	$service->setOrigin('01234456');
    	$service->setDestination('01234456');
    	$service->setOwnHand(true);
    	$service->setReceipt(true);

    	$service->addItem(1,1,1,1,1,1);

    	$this->assertCount(1, $service->listItems());
        
        $expected = [
	        'from' => [ 'postal_code' => '01234456'],
	        'to' => [ 'postal_code' => '01234456'],
	        'products' => [
	        	0 => [
		        	'id' => 1, 
		        	'width' => 1,
		        	'height' => 1,
		        	'length' => 1,
		        	'weight' => 1,
		        	'insurance_value' => 1,
		        	'quantity' => 1
		        ]
	        ],
	        'options' => [
	        	'receipt' => true, 
	        	'own_hand' => true
	        ],
	    ];

	    $result = $service->payload();
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function the_request_can_remove_a_item()
    {
    	$service = new ProductsShipCalculator();

    	$service->addItem(1,1,1,1,1,1);
		$itemsCount = $service->listItems();
    	$this->assertCount(1, $itemsCount);
        
        $service->removeItem(0);
		$itemsCount = $service->listItems();
        $this->assertCount(0, $itemsCount);
    }

    /** @test */
    public function the_request_trow_error_without_items()
    {
    	$service = new ProductsShipCalculator();

    	$this->expectException(MelhorEnvioException::class);

    	$service->payload();
    }
}
