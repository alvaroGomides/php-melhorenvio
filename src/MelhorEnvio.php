<?php

namespace AlvaroGomides\MelhorEnvio;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;

class MelhorEnvio
{
    const PROD_API_ENDPOINT = 'https://www.melhorenvio.com.br';
    const DEV_API_ENDPOINT = 'https://sandbox.melhorenvio.com.br';

    protected $apiClient;

    protected $endpoint_prefix;

    public function __construct($enviroment = 'prod')
    {
        if($enviroment == 'prod'):
        	$this->endpoint_prefix = self::PROD_API_ENDPOINT;
	    else:
	    	$this->endpoint_prefix = self::DEV_API_ENDPOINT;
	    endif;

	    $this->apiClient = new HttpClient(['base_uri' => $this->endpoint_prefix]);
    }



}
