<?php

require 'init.php';

$gateway = new \ByTIC\Omnipay\Mobilpay\Gateway();

$parameters = [
    'signature' => getenv('MOBILPAY_SIGNATURE'),
    'certificate' => getenv('MOBILPAY_CERTIFICATE'),
    'privateKey' => getenv('MOBILPAY_KEY'),
    'orderId' => 1,
    'amount' => 20.00,
//    'card' => ['first_name' => 'Gabriel','last_name' => 'Solomon'],
];
$request = $gateway->purchase($parameters);
$response = $request->send();

// Send the Symfony HttpRedirectResponse
$response->send();
