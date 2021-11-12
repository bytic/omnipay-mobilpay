<?php

namespace Paytic\Omnipay\Mobilpay\Tests\Message;

use Paytic\Omnipay\Mobilpay\Message\PurchaseRequest;
use Paytic\Omnipay\Mobilpay\Message\PurchaseResponse;
use Paytic\Omnipay\Mobilpay\Models\PaymentSplit;
use Paytic\Omnipay\Mobilpay\Models\Request\Card;
use Http\Discovery\Psr17FactoryDiscovery;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class PurchaseRequestTest
 * @package Paytic\Omnipay\Mobilpay\Tests\Message
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
        $data = require TEST_FIXTURE_PATH.'/requests/PurchaseRequest/baseRequest.php';
        $data['lang'] = 'en';
        $request = $this->newRequestWithInitTest(PurchaseRequest::class, $data);

        /** @var PurchaseResponse $response */
        $response = $request->send();
        self::assertInstanceOf(PurchaseResponse::class, $response);

        $data = $response->getRedirectData();
        self::assertCount(2, $data);

        $client = $this->getHttpClientReal();
        $body = Psr17FactoryDiscovery::findStreamFactory()->createStream(http_build_query($data, '', '&'));
        $gatewayResponse = $client->request(
            'POST',
            $response->getRedirectUrl(),
            ['Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8'],
            $body
        );
        self::assertSame(200, $gatewayResponse->getStatusCode());
//        self::assertStringEndsWith('mobilpay.ro/en', $gatewayResponse->getU());

        //Validate first Response
        $body = $gatewayResponse->getBody()->__toString();
        self::assertRegexp('/Transaction ID/', $body);
        self::assertRegexp('/Payment description/', $body);
        self::assertRegexp('/Merchant website/', $body);
    }

    public function test_generateMobilpayPaymentSplit()
    {
        $data = require TEST_FIXTURE_PATH.'/requests/PurchaseRequest/baseRequest.php';
        $data['split'] = [
            123 => 12,
            789 => 8,
        ];

        $request = $this->newRequestWithInitTest(PurchaseRequest::class, $data);

        $card = $request->populateMobilpayCardRequest();
        self::assertInstanceOf(Card::class, $card);

        $split = $card->split;
        self::assertInstanceOf(PaymentSplit::class, $split);

        $destination = $split->destinations;
        self::assertCount(2, $destination);

        self::assertSame(['id' => 123, 'amount' => 12], $destination[0]);
        self::assertSame(['id' => 789, 'amount' => 8], $destination[1]);
    }
}
