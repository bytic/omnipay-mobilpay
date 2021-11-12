<?php

use Paytic\Omnipay\Mobilpay\Models\Soap\Person;

$gateway = require '_init.php';

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
    'sessionId' => $sessionId,
    'sacId' => getenv('MOBILPAY_SIGNATURE'),
    'orderId' => '999',
];
var_dump($parameters);

$request = $gateway->cancelRecurrence($parameters);
$response = $request->send();

var_dump($response->getData());
