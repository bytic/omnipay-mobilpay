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
        $client = $this->getHttpClient();
        $httpRequest = HttpRequestBuilder::createServerCompletePurchase();
        $request = new ServerCompletePurchaseRequest($client, $httpRequest);

        $data = [
            'signature' => getenv('MOBILPAY_SIGNATURE'),
            'certificate' => getenv('MOBILPAY_PUBLIC_CER'),
            'privateKey' => getenv('MOBILPAY_PRIVATE_KEY'),
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
        self::assertSame('150.00', $cardRequest->invoice->amount);
        self::assertSame('Donatie pentru Alaturi de Madalin via Alina Cilil', $cardRequest->invoice->details);

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
        self::assertSame('39188', $cardRequest->orderId);
    }

    /**
     * @param Address $address
     */
    protected function validateAddressObject($address)
    {
        self::assertInstanceOf(Address::class, $address);
        self::assertSame('Alina', $address->firstName);
        self::assertSame('S', $address->lastName);
    }

    /**
     * @param Notify $notify
     */
    protected function validateNotifyObject($notify)
    {
        self::assertInstanceOf(Notify::class, $notify);
        self::assertSame('35410438', $notify->purchaseId);
        self::assertSame('confirmed', $notify->action);
        self::assertSame('0', $notify->errorCode);
        self::assertSame('Tranzactia aprobata', $notify->errorMessage);
        self::assertSame('20161023150844', $notify->timestamp);
        self::assertSame('150.00', $notify->originalAmount);
        self::assertSame('150.00', $notify->processedAmount);
        self::assertSame(null, $notify->promotionAmount);
        self::assertSame('1', $notify->current_payment_count);
        self::assertSame('5****8655', $notify->pan_masked);
        self::assertSame(null, $notify->token_id);
        self::assertSame('1e59360874ae14eb39c7a038b205bf0d', $notify->getCrc());
    }

    public function testSend()
    {
        $client = $this->getHttpClient();
        $httpRequest = HttpRequestBuilder::createServerCompletePurchase();
        $request = new ServerCompletePurchaseRequest($client, $httpRequest);

        $data = [
            'signature' => getenv('MOBILPAY_SIGNATURE'),
            'certificate' => getenv('MOBILPAY_PUBLIC_CER'),
            'privateKey' => getenv('MOBILPAY_PRIVATE_KEY'),
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
            '<?xml version="1.0" encoding="utf-8"?>'."\n".'<crc>1e59360874ae14eb39c7a038b205bf0d</crc>',
            $response->getContent()
        );
    }
}
