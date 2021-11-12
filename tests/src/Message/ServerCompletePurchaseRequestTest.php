<?php

namespace Paytic\Omnipay\Mobilpay\Tests\Message;

use ByTIC\Omnipay\Common\Models\Token;
use Paytic\Omnipay\Mobilpay\Message\ServerCompletePurchaseRequest;
use Paytic\Omnipay\Mobilpay\Message\ServerCompletePurchaseResponse;
use Paytic\Omnipay\Mobilpay\Models\Address;
use Paytic\Omnipay\Mobilpay\Models\Invoice;
use Paytic\Omnipay\Mobilpay\Models\Request\Card;
use Paytic\Omnipay\Mobilpay\Models\Request\Notify;
use Paytic\Omnipay\Mobilpay\Tests\Fixtures\HttpRequestBuilder;

/**
 * Class ServerCompletePurchaseRequestTest
 * @package Paytic\Omnipay\Mobilpay\Tests\Message
 */
class ServerCompletePurchaseRequestTest extends AbstractRequestTest
{
    public function testDecodeXML()
    {
        $client = $this->getHttpClient();
        $httpRequest = HttpRequestBuilder::createServerCompletePurchase();
        $request = new ServerCompletePurchaseRequest($client, $httpRequest);

        $data = [
            'signature' => getenv('MOBILPAY_SIGNATURE'),
            'certificate' => getenv('MOBILPAY_PUBLIC_CER'),
            'privateKey' => getenv('MOBILPAY_PRIVATE_KEY_SANDBOX'),
        ];
        $request->initialize($data);

        self::assertEquals(
            file_get_contents(TEST_FIXTURE_PATH.'/requests/serverCompletePurchase.xml'),
            $request->getDecodedXML()
        );
    }

    public function testParseXml()
    {
        $client = $this->getHttpClient();
        $httpRequest = HttpRequestBuilder::createServerCompletePurchase();
        $request = new ServerCompletePurchaseRequest($client, $httpRequest);

        $cardRequest = $request->parseXml(
            file_get_contents(TEST_FIXTURE_PATH.'/requests/serverCompletePurchase.xml')
        );

        $this->validateCardObject($cardRequest);

        self::assertInstanceOf(Invoice::class, $cardRequest->invoice);
        self::assertSame('RON', $cardRequest->invoice->currency);
        self::assertSame('25.00', $cardRequest->invoice->amount);
//        self::assertSame('Donatie pentru Alaturi de Madalin via Alina Cilil', $cardRequest->invoice->details);

        $this->validateAddressObject($cardRequest->invoice->getBillingAddress());
        $this->validateAddressObject($cardRequest->invoice->getShippingAddress());

        $this->validateNotifyObject($cardRequest->notifyResponse);
    }

    /**
     * @param Card $cardRequest
     */
    protected function validateCardObject($cardRequest)
    {
        self::assertInstanceOf(Card::class, $cardRequest);
        self::assertSame('1619511426', $cardRequest->orderId);
    }

    /**
     * @param Address $address
     */
    protected function validateAddressObject($address)
    {
        self::assertInstanceOf(Address::class, $address);
        self::assertSame('Gabriel', $address->firstName);
        self::assertSame('Solomon', $address->lastName);
    }

    /**
     * @param Notify $notify
     */
    protected function validateNotifyObject($notify)
    {
        self::assertInstanceOf(Notify::class, $notify);
        self::assertSame('1219841', $notify->purchaseId);
        self::assertSame('confirmed', $notify->action);
        self::assertSame('0', $notify->errorCode);
        self::assertSame('Transaction approved', $notify->errorMessage);
        self::assertSame('20210427112031', $notify->timestamp);
        self::assertSame('25.00', $notify->originalAmount);
        self::assertSame('25.00', $notify->processedAmount);
        self::assertSame(null, $notify->promotionAmount);
        self::assertSame('1', $notify->current_payment_count);
        self::assertSame('9****5098', $notify->pan_masked);
        self::assertSame('47b6a77de9854bba047b5d2889f9d13b', $notify->getCrc());
    }

    public function testSend()
    {
        $client = $this->getHttpClient();
        $httpRequest = HttpRequestBuilder::createServerCompletePurchase();
        $request = new ServerCompletePurchaseRequest($client, $httpRequest);

        $data = [
            'signature' => getenv('MOBILPAY_SIGNATURE'),
            'certificate' => getenv('MOBILPAY_PUBLIC_CER'),
            'privateKey' => getenv('MOBILPAY_PRIVATE_KEY_SANDBOX'),
        ];
        $request->initialize($data);
        $response = $request->send();

        self::assertInstanceOf(ServerCompletePurchaseResponse::class, $response);

        $data = $response->getData();
        $this->validateCardObject($data['cardRequest']);
        $this->validateNotifyObject($data['notification']);

        $token = $response->getToken();
        self::assertInstanceOf(Token::class, $token);
        self::assertSame(
            'MTI2NzgxOvU9tf//XCNC0taaYWK6W0Cj1a+5DhmSx6yIr+DImuz33wtQ+5q8d33qPngNshlSU6qAaZq4/9zbUM3uAPijRuA=',
            $token->getId()
        );
        self::assertSame('2022-01-01 00:00:00', $token->getExpirationDate()->format('Y-m-d H:i:s'));

        self::assertTrue($response->isSuccessful());
        self::assertFalse($response->isCancelled());
        self::assertFalse($response->isPending());
        self::assertSame(
            '<?xml version="1.0" encoding="utf-8"?>'."\n".'<crc>47b6a77de9854bba047b5d2889f9d13b</crc>',
            $response->getContent()
        );
    }
}
