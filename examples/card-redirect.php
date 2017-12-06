<?php

require 'init.php';

$gateway = new \ByTIC\Omnipay\Mobilpay\Gateway();

$parameters = [
    'signature' => $_ENV['MOBILPAY_SIGNATURE'],
    'certificate' => $_ENV['MOBILPAY_CERTIFICATE'],
    'privateKey' => $_ENV['MOBILPAY_KEY'],
    'orderId' => 99999,
    'amount' => 20.00,
//    'card' => ['first_name' => 'Gabriel','last_name' => 'Solomon'],
];
$request = $gateway->purchase($parameters);
$response = $request->send();

// Send the Symfony HttpRedirectResponse
$response->send();
