<?php

require 'init.php';

$gateway = new \ByTIC\Omnipay\Mobilpay\Gateway();

$parameters = [
    'username' => getenv('MOBILPAY_EMAIL'),
    'password' => getenv('MOBILPAY_PASSWORD'),
];
$request = $gateway->logIn($parameters);
$response = $request->send();

// PRINT SESSION ID
$sessionId = $response->getData();
var_dump($sessionId);

$parameters = [
    'amount' => 20.00,
    'orderId' => 999,
    'card' => ['firstName' => 'Gabriel', 'lastName' => 'Solomon'],
];
//$request = $gateway->registerCompany($parameters);
//$response = $request->send();
//
//// Send the Symfony HttpRedirectResponse
//$response->send();
