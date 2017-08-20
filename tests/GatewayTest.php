<?php

namespace ByTIC\Omnipay\Mobilpay\Tests;

use ByTIC\Omnipay\Mobilpay\Gateway;

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
}
