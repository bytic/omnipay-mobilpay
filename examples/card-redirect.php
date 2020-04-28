<?php

require 'init.php';

$gateway = new \ByTIC\Omnipay\Mobilpay\Gateway();
$gateway->initialize([
    'signature' => getenv('MOBILPAY_SIGNATURE'),
    'certificate' => getenv('MOBILPAY_PUBLIC_CER'),
    'privateKey' => getenv('MOBILPAY_PRIVATE_KEY'),
//     'lang' => 'en',
    'testMode' => false,
]);

$parameters = [
    'amount' => 20.00,
    'orderId' => 999,
//     'lang' => 'en',
    'card' => ['firstName' => 'Gabriel', 'lastName' => 'Solomon'],
];
$request = $gateway->purchase($parameters);
$response = $request->send();

// Send the Symfony HttpRedirectResponse
$response->send();
