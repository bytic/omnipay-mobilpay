<?php

namespace ByTIC\Omnipay\Mobilpay\Tests\Models\Soap;

use ByTIC\Omnipay\Mobilpay\Models\Soap\Address;
use ByTIC\Omnipay\Mobilpay\Models\Soap\Bank;
use ByTIC\Omnipay\Mobilpay\Models\Soap\Company;
use ByTIC\Omnipay\Mobilpay\Models\Soap\SellerAccount;
use ByTIC\Omnipay\Mobilpay\Models\Soap\SellerAccountList;
use ByTIC\Omnipay\Mobilpay\Tests\AbstractTest;

/**
 * Class CompanyTest
 * @package ByTIC\Omnipay\Mobilpay\Tests\Models\Soap
 */
class CompanyTest extends AbstractTest
{
    public function test_fromArray()
    {
        $data = [
            'name' => 'Test Company',
            'type' => 1,
            'code' => '999',
            'reg_code' => 'J00/0000/1900',
            'vat' => true,
            'payment_methods' => [1],
            'address' => [
                'country' => '',
                'county' => '',
                'address' => '',
                'postal_code' => '',
            ],
            'bank' => [
                'name' => 'ING BANK',
                'branch' => 'ING Militari',
                'iban' => 'RO99INGB0000000',
            ],
            'fax' => '11111',
            'seller_accounts' => [
                'name' => '',
                'description' => '',
                'under_contruction' => false,
                'payment_methods' => [1],
                'url' => '',
                'confirm_url' => '',
                'return_url' => '',
                'mobilpay_key' => '',
                'merchant_key' => '',
                'signature' => '',
            ],
        ];

        $company = Company::fromArray($data);
        self::assertInstanceOf(Company::class, $company);
        self::assertSame($data['type'], $company->getType());
        self::assertSame($data['code'], $company->getCode());
        self::assertSame($data['fax'], $company->getFax());

        $address = $company->getAddress();
        self::assertInstanceOf(Address::class, $address);
        self::assertSame($data['address']['country'], $address->getCountry());
        self::assertSame($data['address']['county'], $address->getCounty());

        $bank = $company->getBank();
        self::assertInstanceOf(Bank::class, $bank);
        self::assertSame($data['bank']['name'], $bank->getName());
        self::assertSame($data['bank']['iban'], $bank->getIban());

        $sellerAccounts = $company->getSellerAccounts();
        self::assertInstanceOf(SellerAccountList::class, $sellerAccounts);

        /** @var SellerAccountList $sellerAccounts */
        $sellerAccounts = $sellerAccounts->getItems();
        /** @var SellerAccount $sellerAccount */
        $sellerAccount = reset($sellerAccounts);
        self::assertInstanceOf(SellerAccount::class, $sellerAccount);
        self::assertSame($data['seller_accounts']['name'], $sellerAccount->getName());
        self::assertSame($data['seller_accounts']['description'], $sellerAccount->getDescription());
        self::assertSame($data['seller_accounts']['payment_methods'], $sellerAccount->getPaymentMethods());
    }
}
