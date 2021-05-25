<?php

namespace ByTIC\Omnipay\Mobilpay\Tests\Message;

use ByTIC\Omnipay\Mobilpay\Message\ServerCompletePurchaseRequest;
use ByTIC\Omnipay\Mobilpay\Tests\Fixtures\HttpRequestBuilder;

/**
 * Class ServerCompletePurchaseRequestTest
 * @package ByTIC\Omnipay\Mobilpay\Tests\Message
 */
class ServerCompletePurchaseResponseTest extends AbstractRequestTest
{
    public function test_getCardMasked()
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

        self::assertEquals(
            '9****5098',
            $response->getCardMasked()
        );
    }
}
