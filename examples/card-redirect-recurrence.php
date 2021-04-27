<?php

$gateway = require '_init.php';

$parameters = [
    'amount' => 3.00,
    'orderId' => 999,
//     'lang' => 'en',
    'card' => ['firstName' => 'Gabriel', 'lastName' => 'Solomon'],
    'recurrence' => ['times' =>  10, 'interval' => '30'],
];
$request = $gateway->purchase($parameters);
$response = $request->send();

// Send the Symfony HttpRedirectResponse
$response->send();
