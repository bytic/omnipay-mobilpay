<?php

namespace ByTIC\Omnipay\Mobilpay\Message\Soap\Payment;

use ByTIC\Omnipay\Mobilpay\Message\Soap\AbstractSoapRequest;
use ByTIC\Omnipay\Mobilpay\Message\Soap\Traits\HasSacId;
use ByTIC\Omnipay\Mobilpay\Message\Soap\Traits\HasSessionId;
use ByTIC\Omnipay\Mobilpay\Utils\Settings;

/**
 * Class AbstractPaymentSoapRequest
 * @package ByTIC\Omnipay\Mobilpay\Message\Soap\Payment
 */
abstract class AbstractPaymentSoapRequest extends AbstractSoapRequest
{
    use HasSessionId;
    use HasSacId;

    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function getEndpoint(): string
    {
        return $this->getTestMode() === false
            ? Settings::SOAP_PAYMENT_LIVE
            : Settings::SOAP_PAYMENT_SANDBOX;
    }
}
