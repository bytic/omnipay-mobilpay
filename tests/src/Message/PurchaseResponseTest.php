<?php

namespace Paytic\Omnipay\Mobilpay\Tests\Message;

use Paytic\Omnipay\Mobilpay\Message\PurchaseRequest;
use Paytic\Omnipay\Mobilpay\Message\PurchaseResponse;

/**
 * Class PurchaseResponseTest
 * @package Paytic\Omnipay\Mobilpay\Tests\Message
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
