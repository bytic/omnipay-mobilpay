<?php

namespace ByTIC\Omnipay\Mobilpay\Message\Soap\Payment;

use ByTIC\Omnipay\Mobilpay\Message\Soap\Traits\HasOrderId;

/**
 * Class DoPayTRequest
 * @package ByTIC\Omnipay\Mobilpay\Message\Soap\Payment
 */
class DoPayTRequest extends AbstractPaymentSoapRequest
{
    protected function runTransaction($soapClient, $data)
    {
        return $this->runSoapTransaction($soapClient, 'doPayT', $data);
    }

    public function getData()
    {
        $this->validate('sessionId', 'sacId', 'orderId');

        $request = new \stdClass();
        $request->sessionId = $this->getSessionId();
        $request->sacId = $this->getSacId();
        $request->orderId = $this->getOrderId();
//        [
//            'sessionId' => $this->getSessionId(),
//            'sacId' => $this->getSacId(),
//            'orderId' => $this->getOrderId(),
//        ],
        return [
//            'parameters' => [
                'request' => $request,
//            ],
        ];
    }
}
