<?php

namespace Paytic\Omnipay\Mobilpay\Tests\Message;

use Paytic\Omnipay\Mobilpay\Message\CompletePurchaseRequest;
use Paytic\Omnipay\Mobilpay\Message\CompletePurchaseResponse;
use Paytic\Omnipay\Mobilpay\Tests\Fixtures\HttpRequestBuilder;

/**
 * Class CompletePurchaseRequestTest
 * @package Paytic\Omnipay\Mobilpay\Tests\Message
 */
class CompletePurchaseRequestTest extends AbstractRequestTest
{
    public function testSimpleSend()
    {
        $client = $this->getHttpClient();
        $httpRequest = HttpRequestBuilder::createCompletePurchase();
        $request = new CompletePurchaseRequest($client, $httpRequest);

        /** @var CompletePurchaseResponse $response */
        $response = $request->send();
        self::assertInstanceOf(CompletePurchaseResponse::class, $response);
        self::assertSame($httpRequest->query->get('orderId'), $response->getDataProperty('orderId'));
    }
}
