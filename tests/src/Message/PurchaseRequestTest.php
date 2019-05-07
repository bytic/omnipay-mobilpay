<?php

namespace ByTIC\Omnipay\Mobilpay\Tests\Message;

use ByTIC\Omnipay\Mobilpay\Message\PurchaseRequest;
use ByTIC\Omnipay\Mobilpay\Message\PurchaseResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Guzzle\Http\Client as HttpClient;

/**
 * Class PurchaseRequestTest
 * @package ByTIC\Omnipay\Mobilpay\Tests\Message
 */
class PurchaseRequestTest extends AbstractRequestTest
{
    public function testInitParameters()
    {
        $data = [
            'signature' => 111,
            'certificate' => 222,
            'privateKey' => 333,
            'endpointUrl' => 444,
        ];
        $request = $this->newRequestWithInitTest(PurchaseRequest::class, $data);
        self::assertEquals($data['signature'], $request->getSignature());
        self::assertEquals($data['certificate'], $request->getCertificate());
        self::assertEquals($data['privateKey'], $request->getPrivateKey());
        self::assertEquals($data['endpointUrl'], $request->getEndpointUrl());
    }

    public function testSendWithMissingAmount()
    {
        $data = [
            'signature' => 111,
            'certificate' => 222,
            'privateKey' => 333,
            'endpointUrl' => 444,
        ];
        $request = $this->newRequestWithInitTest(PurchaseRequest::class, $data);

        self::expectException(InvalidRequestException::class);
        self::expectExceptionMessage('The amount parameter is required');
        $request->send();
    }

    public function testSend()
    {
        $data = [
            'signature' => getenv('MOBILPAY_SIGNATURE'),
            'certificate' => getenv('MOBILPAY_CERTIFICATE'),
            'privateKey' => getenv('MOBILPAY_KEY'),
            'orderId' => 1,
            'endpointUrl' => 'http://sandboxsecure.mobilpay.ro',
            'card' => [
                'first_name' => '',
            ],
            'amount' => 20.00,
        ];
        $request = $this->newRequestWithInitTest(PurchaseRequest::class, $data);

        /** @var PurchaseResponse $response */
        $response = $request->send();
        self::assertInstanceOf(PurchaseResponse::class, $response);

        $data = $response->getRedirectData();
        self::assertCount(2, $data);

        $client = new HttpClient();
        $gatewayResponse = $client->post($response->getRedirectUrl(), null, $data)->send();
        self::assertSame(200, $gatewayResponse->getStatusCode());
        self::assertStringEndsWith('mobilpay.ro', $gatewayResponse->getEffectiveUrl());

        //Validate first Response
        $body = $gatewayResponse->getBody(true);
        self::assertContains('ID Tranzactie', $body);
        self::assertContains('Descriere plata', $body);
        self::assertContains('Site comerciant', $body);
    }
}
