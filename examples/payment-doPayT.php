<?php

declare(strict_types=1);

/** @var Gateway $gateway */

use Paytic\Omnipay\Mobilpay\Gateway;

$gateway = require '_init.php';

$parameters = [
    'amount' => 10.50,
    'description' => 'desc',
    'currency' => 'RON',
    'orderId' => time(),
    'clientIp' => '127.0.0.1',
    'lang' => 'en',
    'token' => 'MjExNzQ1MDk6LqUHDedY4z6y3A2Vn9GCns0+yT0agJ6Kt++PyHP7yDZ6hBv21hIflIcsrghXc2y7GpblfTdEjQn8jHRpmWefbg==',
    'returnUrl' => CURRENT_URL,
    'notifyUrl' => 'http://localhost',
    'card' => [
        'firstName' => 'Gabriel',
        'lastName' => 'Solomon',
        'email' => 'solomongaby@yahoo.com',
        'phone' => '0741040219',
    ],
];

$request = $gateway->purchaseWithToken($parameters);
$response = $request->send();

var_dump($response->getCode());
var_dump($response->isSuccessful());
var_dump($response->getData());
