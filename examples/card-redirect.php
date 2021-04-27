<?php

$gateway = require '_init.php';

$parameters = [
    'amount' => 20,
    'currency' => 'RON',
    'orderId' => time(),
    'lang' => 'en',
    'returnUrl' => CURRENT_URL,
    'notifyUrl' => 'https://hookb.in/aBgWzq1mMjI1oobLKDPr',
    'card' => ['firstName' => 'Gabriel', 'lastName' => 'Solomon'],
];
$request = $gateway->purchase($parameters);
$response = $request->send();

// Send the Symfony HttpRedirectResponse
$response->send();
