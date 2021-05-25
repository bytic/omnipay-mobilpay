<?php

namespace ByTIC\Omnipay\Mobilpay\Message\Soap\Payment;

use ByTIC\Omnipay\Mobilpay\Utils\Traits\HasOrderId;

/**
 * Class CancelRecurrenceRequest
 * @package ByTIC\Omnipay\Mobilpay\Message\Soap\Payment
 */
class CancelRecurrenceRequest extends AbstractPaymentSoapRequest
{
    use HasOrderId;

    protected function runTransaction($soapClient, $data)
    {
        return $this->runSoapTransaction($soapClient, 'cancelRecurrence', $data);
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
