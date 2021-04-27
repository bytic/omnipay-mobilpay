<?php

require 'init.php';

$gateway = new \ByTIC\Omnipay\Mobilpay\Gateway();
$gateway->initialize(
    [
        'signature' => getenv('MOBILPAY_SIGNATURE'),
        'certificate' => getenv('MOBILPAY_PUBLIC_CER'),
        'privateKey' => getenv('MOBILPAY_PRIVATE_KEY'),
//     'lang' => 'en',
        'testMode' => true,
    ]
);

$parameters = [
    'amount' => 25,
    'currency' => 'RON',
    'orderId' => time(),
    'lang' => 'en',
    'returnUrl' => CURRENT_URL,
    'notifyUrl' => 'https://hookb.in/6JzD2jgN2qFLbb031pLE',
    'card' => ['firstName' => 'Gabriel', 'lastName' => 'Solomon'],
];
$request = $gateway->purchase($parameters);
$response = $request->send();

// Send the Symfony HttpRedirectResponse
$response->send();
