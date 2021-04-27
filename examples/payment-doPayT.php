<?php

$gateway = require '_init.php';

$parameters = [
    'amount' => 20.30,
    'description' => 'desc',
    'currency' => 'RON',
    'orderId' => time(),
    'clientIp' => '127.0.0.1',
    'lang' => 'en',
    'token' => '____',
    'returnUrl' => CURRENT_URL,
    'notifyUrl' => 'http://localhost',
    'card' => [
        'firstName' => 'Gabriel',
        'lastName' => 'Solomon',
        'email' => 'solomongaby@yahoo.com',
        'phone' => '0741040219',
        'address1' => 'Test',
    ],
];

$request = $gateway->doPayT($parameters);
$response = $request->send();

var_dump($response->getData());
