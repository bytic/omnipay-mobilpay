<?php

namespace ByTIC\Omnipay\Mobilpay\Tests\Message;

use ByTIC\Omnipay\Mobilpay\Message\PurchaseRequest;
use ByTIC\Omnipay\Mobilpay\Message\PurchaseResponse;
use Omnipay\Common\Exception\InvalidRequestException;

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
            'signature' => 111,
            'certificate' => 222,
            'privateKey' => 333,
            'endpointUrl' => 444,
            'amount' => 20,
        ];
        $request = $this->newRequestWithInitTest(PurchaseRequest::class, $data);

        $response = $request->send();
        self::assertInstanceOf(PurchaseResponse::class, $response);
    }
}