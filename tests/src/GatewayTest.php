<?php

namespace Paytic\Omnipay\Mobilpay\Tests;

use Paytic\Omnipay\Mobilpay\Gateway;
use Paytic\Omnipay\Mobilpay\Message\PurchaseRequest;

/**
 * Class HelperTest
 * @package ByTIC\Omnipay\Twispay\Tests
 */
class GatewayTest extends AbstractTest
{
    public function testGetSecureUrl()
    {
        $gateway = new Gateway();

        // INITIAL TEST MODE IS TRUE
        self::assertEquals(
            'http://sandboxsecure.mobilpay.ro',
            $gateway->getEndpointUrl()
        );

        $gateway->setTestMode(true);
        self::assertEquals(
            'http://sandboxsecure.mobilpay.ro',
            $gateway->getEndpointUrl()
        );

        $gateway->setTestMode(false);
        self::assertEquals(
            'https://secure.mobilpay.ro',
            $gateway->getEndpointUrl()
        );
    }

    public function testPurchaseRequestEndpointUrl()
    {
        $gateway = new Gateway();

        $request = $gateway->purchase();
        self::assertInstanceOf(PurchaseRequest::class, $request);
    }

    public function testSetCertificateFile()
    {
        $gateway = new Gateway();
        $gateway->setCertificate(TEST_FIXTURE_PATH.'/files/public.cer');
        self::assertSame('CERTIFICATE', $gateway->getCertificate());
    }

    public function testSetPrivateKeyFile()
    {
        $gateway = new Gateway();
        $gateway->setPrivateKey(TEST_FIXTURE_PATH.'/files/private.key');
        self::assertSame('KEY', $gateway->getPrivateKey());
    }
}
