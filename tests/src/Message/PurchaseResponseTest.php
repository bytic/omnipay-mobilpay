<?php

namespace ByTIC\Omnipay\Mobilpay\Tests\Message;

use ByTIC\Omnipay\Mobilpay\Message\PurchaseRequest;
use ByTIC\Omnipay\Mobilpay\Message\PurchaseResponse;

/**
 * Class PurchaseResponseTest
 * @package ByTIC\Omnipay\Mobilpay\Tests\Message
 */
class PurchaseResponseTest extends AbstractResponseTest
{
    public function testGetRedirectData()
    {
        $data = [
            'env_key' => '123',
            'data' => '456',
        ];
        $response = $this->newResponse(PurchaseRequest::class, $data);
        self::assertInstanceOf(PurchaseResponse::class, $response);
        self::assertSame($data, $response->getRedirectData());
    }
}
