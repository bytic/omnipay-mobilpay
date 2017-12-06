<?php

namespace ByTIC\Omnipay\Mobilpay\Tests\Message;

use ByTIC\Omnipay\Mobilpay\Message\ServerCompletePurchaseRequest;
use ByTIC\Omnipay\Mobilpay\Message\ServerCompletePurchaseResponse;
use ByTIC\Omnipay\Mobilpay\Models\Address;
use ByTIC\Omnipay\Mobilpay\Models\Invoice;
use ByTIC\Omnipay\Mobilpay\Models\Request\Card;
use ByTIC\Omnipay\Mobilpay\Models\Request\Notify;
use ByTIC\Omnipay\Mobilpay\Tests\Fixtures\HttpRequestBuilder;
use Guzzle\Http\Client as HttpClient;

/**
 * Class ServerCompletePurchaseRequestTest
 * @package ByTIC\Omnipay\Mobilpay\Tests\Message
 */
class ServerCompletePurchaseRequestTest extends AbstractRequestTest
{

    public function testDecodeXML()
    {
        $client = new HttpClient();
        $httpRequest = HttpRequestBuilder::createServerCompletePurchase();
        $request = new ServerCompletePurchaseRequest($client, $httpRequest);

        $data = [
            'signature' => $_ENV['MOBILPAY_SIGNATURE'],
            'certificate' => $_ENV['MOBILPAY_CERTIFICATE'],
            'privateKey' => $_ENV['MOBILPAY_KEY'],
        ];
        $request->initialize($data);

        self::assertSame(
            file_get_contents(TEST_FIXTURE_PATH.'/requests/serverCompletePurchase.xml'),
            $request->getDecodedXML()
        );
    }

    public function testParseXml()
    {
        $client = new HttpClient();
        $httpRequest = HttpRequestBuilder::createServerCompletePurchase();
        $request = new ServerCompletePurchaseRequest($client, $httpRequest);

        $cardRequest = $request->parseXml(
            file_get_contents(TEST_FIXTURE_PATH.'/requests/serverCompletePurchase.xml')
        );

        $this->validateCardObject($cardRequest);

        self::assertInstanceOf(Invoice::class, $cardRequest->invoice);
        self::assertSame('RON', $cardRequest->invoice->currency);
        self::assertSame('20.00', $cardRequest->invoice->amount);
        self::assertSame('Comanda', $cardRequest->invoice->details);

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
        self::assertSame('99999', $cardRequest->orderId);
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
        self::assertSame('488101', $notify->purchaseId);
        self::assertSame('confirmed', $notify->action);
        self::assertSame('0', $notify->errorCode);
        self::assertSame('Tranzactia aprobata', $notify->errorMessage);
        self::assertSame('20170821180018', $notify->timestamp);
        self::assertSame('20.00', $notify->originalAmount);
        self::assertSame('20.00', $notify->processedAmount);
        self::assertSame(null, $notify->promotionAmount);
        self::assertSame('1', $notify->current_payment_count);
        self::assertSame('9****5098', $notify->pan_masked);
        self::assertSame(null, $notify->token_id);
        self::assertSame('5adc97ca3bf455e2538951822fa49f13', $notify->getCrc());
    }

    public function testSend()
    {
        $client = new HttpClient();
        $httpRequest = HttpRequestBuilder::createServerCompletePurchase();
        $request = new ServerCompletePurchaseRequest($client, $httpRequest);

        $data = [
            'signature' => $_ENV['MOBILPAY_SIGNATURE'],
            'certificate' => $_ENV['MOBILPAY_CERTIFICATE'],
            'privateKey' => $_ENV['MOBILPAY_KEY'],
        ];
        $request->initialize($data);
        $response = $request->send();

        self::assertInstanceOf(ServerCompletePurchaseResponse::class, $response);

        $data = $response->getData();
        $this->validateCardObject($data['cardRequest']);
        $this->validateNotifyObject($data['notification']);

        self::assertTrue($response->isSuccessful());
        self::assertFalse($response->isCancelled());
        self::assertFalse($response->isPending());
        self::assertSame(
            '<?xml version="1.0" encoding="utf-8"?>'."\n".'<crc>5adc97ca3bf455e2538951822fa49f13</crc>',
            $response->getContent()
        );
    }
}
