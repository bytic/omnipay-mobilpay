<?php

namespace ByTIC\Omnipay\Mobilpay\Tests\Message;

use ByTIC\Omnipay\Mobilpay\Message\CompletePurchaseRequest;
use ByTIC\Omnipay\Mobilpay\Message\CompletePurchaseResponse;
use ByTIC\Omnipay\Mobilpay\Tests\Fixtures\HttpRequestBuilder;
use Guzzle\Http\Client as HttpClient;

/**
 * Class CompletePurchaseRequestTest
 * @package ByTIC\Omnipay\Mobilpay\Tests\Message
 */
class CompletePurchaseRequestTest extends AbstractRequestTest
{
    public function testSimpleSend()
    {
        $client = new HttpClient();
        $httpRequest = HttpRequestBuilder::createCompletePurchase();
        $request = new CompletePurchaseRequest($client, $httpRequest);

        /** @var CompletePurchaseResponse $response */
        $response = $request->send();
        self::assertInstanceOf(CompletePurchaseResponse::class, $response);
        self::assertSame($httpRequest->query->get('orderId'), $response->getDataProperty('orderId'));
    }
}
