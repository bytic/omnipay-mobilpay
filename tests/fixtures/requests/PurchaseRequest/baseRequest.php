<?php

return [
    'signature' => getenv('MOBILPAY_SIGNATURE'),
    'certificate' => getenv('MOBILPAY_PUBLIC_CER'),
    'privateKey' => getenv('MOBILPAY_PRIVATE_KEY'),

    'amount' => 20.00,
    'currency' => 'RON',
    'orderId' => 999,
    'orderName' => 'Test order',
    'orderDate' => '',

    'returnUrl' => 'http://localhost',
    'notifyUrl' => 'http://localhost',
    'testMode' => true,
    'endpointUrl' => 'https://secure.mobilpay.ro',

    'card' => [
        'firstName' => 'Test',
        'lastName' => 'Test',
        'email' => 'test@bytic.ro',
    ]
];
