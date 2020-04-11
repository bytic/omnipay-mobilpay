<?php

return [
    'signature' => getenv('MOBILPAY_SIGNATURE'),
    'certificate' => getenv('MOBILPAY_PUBLIC_CER'),
    'privateKey' => getenv('MOBILPAY_PRIVATE_KEY'),

    'amount' => 20.00,

    'orderId' => 999,
    'orderName' => 'Test order',
    'orderDate' => '',

    'endpointUrl' => 'https://secure.mobilpay.ro',
    'card' => [
        'firstName' => 'Test',
        'lastName' => 'Test',
        'email' => 'test@bytic.ro',
    ]
];
