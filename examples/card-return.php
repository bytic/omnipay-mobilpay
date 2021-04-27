<?php

//$_POST = ['env_key' => '', 'data' => ''];
//$_POST = array_map('urldecode', $_POST);

$gateway = require '_init.php';

$gateway->initialize(
    [
        'signature' => getenv('MOBILPAY_SIGNATURE'),
        'certificate' => getenv('MOBILPAY_PUBLIC_CER'),
        'privateKey' => getenv('MOBILPAY_PRIVATE_KEY_SANDBOX'),
        'testMode' => true,
    ]
);

$parameters = [];
$request = $gateway->serverCompletePurchase($parameters);
$response = $request->send();

var_dump($response);

//// Send the Symfony HttpRedirectResponse
//$response->send();
