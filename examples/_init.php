<?php

use Symfony\Component\HttpFoundation\Request as HttpRequest;

define('CURRENT_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
require dirname(__DIR__).DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.'bootstrap.php';

$request = HttpRequest::createFromGlobals();

$gateway = new \ByTIC\Omnipay\Mobilpay\Gateway(null, $request);

$gateway->initialize(
    [
        'signature' => getenv('MOBILPAY_SIGNATURE'),
        'certificate' => getenv('MOBILPAY_PUBLIC_CER'),
        'privateKey' => getenv('MOBILPAY_PRIVATE_KEY_SANDBOX'),
        'username' => getenv('MOBILPAY_EMAIL'),
        'password' => getenv('MOBILPAY_PASSWORD'),
//     'lang' => 'en',
        'testMode' => true,
    ]
);

return $gateway;