<?php

use ByTIC\Omnipay\Mobilpay\Models\Soap\Person;

require 'init.php';

$gateway = new \ByTIC\Omnipay\Mobilpay\Gateway();

$parameters = [
    'username' => getenv('MOBILPAY_EMAIL'),
    'password' => getenv('MOBILPAY_PASSWORD'),
];
$request = $gateway->logIn($parameters);
$response = $request->send();

// PRINT SESSION ID
$sessionId = $response->getData();
var_dump($sessionId);

$user = \ByTIC\Omnipay\Mobilpay\Models\Soap\User::fromArray([
    'username' => 'test',
    'password' => 'test-pass#123',
    'person' => [
        'first_name' => 'John',
        'last_name' => 'Foe',
        'contacts' => [
            'phone' => '0741040219',
            'email' => 'test@galantom.ro',
        ],
        'type' => Person::TYPE_TEHNICAL,
    ],
]);

$company = \ByTIC\Omnipay\Mobilpay\Models\Soap\Company::fromArray([
    'name' => 'Test Company',
    'type' => 1,
    'code' => '999',
    'reg_code' => 'J09/4578/2018',
    'vat' => true,
    'payment_methods' => [1],
    'address' => [
        'country' => 'Romania',
        'county' => 'Bucuresti',
        'address' => 'Bd. Iuliu Maniu',
        'postal_code' => '600212',
    ],
    'bank' => [
        'name' => 'ING',
        'branch' => 'Iuliu Maniu',
        'iban' => 'RO25BACX0000000731265310',
    ],
    'fax' => '11111',
    'seller_accounts' => [
        'name' => 'GalantPay',
        'description' => 'GalantPay Test',
        'under_contruction' => false,
        'payment_methods' => [1],
        'url' => 'https://pay.galantom.ro',
        'confirm_url' => '',
        'return_url' => '',
        'mobilpay_key' => '',
        'merchant_key' => '',
        'signature' => '',
    ],
]);

$parameters = [
    'sessionId' => $sessionId,
    'request' => [
        'Soap_Type_User' => $user->toSoap(),
        'Soap_Type_Address' => $company->getAddress()->toSoap(),
        'Soap_Type_Bank' => $company->getBank()->toSoap(),
        'Soap_Type_Company' => $company->toSoap(),
    ],
];
var_dump($parameters);

$request = $gateway->validateRequest($parameters);
$response = $request->send();

var_dump($response->getData());
