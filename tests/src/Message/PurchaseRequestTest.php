<?php

namespace ByTIC\Omnipay\Mobilpay\Tests\Message;

use ByTIC\Omnipay\Mobilpay\Message\PurchaseRequest;
use ByTIC\Omnipay\Mobilpay\Message\PurchaseResponse;
use ByTIC\Omnipay\Mobilpay\Models\PaymentSplit;
use ByTIC\Omnipay\Mobilpay\Models\Request\Card;
use Guzzle\Http\Client as HttpClient;
use Omnipay\Common\Exception\InvalidRequestException;

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
        $data = require TEST_FIXTURE_PATH.'/requests/PurchaseRequest/baseRequest.php';
        $data['lang'] = 'en';
        $request = $this->newRequestWithInitTest(PurchaseRequest::class, $data);

        /** @var PurchaseResponse $response */
        $response = $request->send();
        self::assertInstanceOf(PurchaseResponse::class, $response);

        $data = $response->getRedirectData();
        self::assertCount(2, $data);

        $client = new HttpClient();
        $gatewayResponse = $client->post($response->getRedirectUrl(), null, $data)->send();
        self::assertSame(200, $gatewayResponse->getStatusCode());
        self::assertStringEndsWith('mobilpay.ro/en', $gatewayResponse->getEffectiveUrl());

        //Validate first Response
        $body = $gatewayResponse->getBody(true);
        self::assertStringContainsString('Transaction ID', $body);
        self::assertStringContainsString('Payment description', $body);
        self::assertStringContainsString('Merchant website', $body);
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
