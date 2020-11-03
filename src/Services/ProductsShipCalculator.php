<?php

namespace AlvaroGomides\MelhorEnvio\Services;

use AlvaroGomides\MelhorEnvio\MelhorEnvio as MelhorEnvio;
use AlvaroGomides\MelhorEnvio\Exceptions\MelhorEnvioException;

class ProductsShipCalculator extends MelhorEnvio
{
	const API_PATH = '/api/v2/me/shipment/calculate';
	const API_METHOD = 'POST';

    protected $defaultPayload = [
        'from' => [ 'postal_code' => null],
        'to' => [ 'postal_code' => null],
        'products' => array(),
        'options' => [
        	'receipt' => false, 
        	'own_hand' => false
        ],
    ];

    protected $payload = [];

    protected $items = [];

    public function setOrigin(string $zipCode)
    {
        $this->payload['from']['postal_code'] = preg_replace('/[^0-9]/', null, $zipCode);
        return $this;
    }

    public function setDestination(string $zipCode)
    {
        $this->payload['to']['postal_code'] = preg_replace('/[^0-9]/', null, $zipCode);

        return $this;
    }

    public function setOwnHand(bool $own_hand)
    {
        $this->payload['options']['own_hand'] = $own_hand;

        return $this;
    }

    public function setReceipt(bool $receipt)
    {
        $this->payload['options']['receipt'] = $receipt;

        return $this;
    }

    public function addItem($id, $width, $height, $length, $weight, $insurance_value, $quantity = 1)
    {
    	$this->items[] = compact('id', 'width', 'height', 'length', 'weight', 'insurance_value', 'quantity');

    	return $this;
    }

    public function removeItem($itemIndex)
    {
    	unset($this->items[$itemIndex]);

    	return $this;
    }

    public function listItems()
    {
    	return $this->items;
    }

    public function payload()
    {
    	if(empty($this->items))
    		throw new MelhorEnvioException("No items found on Request", 1);
    		
    	$this->payload['products'] = $this->items;

    	return array_merge($this->defaultPayload, $this->payload);
    }

}
