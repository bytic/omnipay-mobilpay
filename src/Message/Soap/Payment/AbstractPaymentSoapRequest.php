<?php

namespace Paytic\Omnipay\Mobilpay\Message\Soap\Payment;

use Paytic\Omnipay\Mobilpay\Message\Soap\AbstractSoapRequest;
use Paytic\Omnipay\Mobilpay\Message\Soap\Traits\HasSacId;
use Paytic\Omnipay\Mobilpay\Message\Soap\Traits\HasSessionId;
use Paytic\Omnipay\Mobilpay\Utils\Settings;

/**
 * Class AbstractPaymentSoapRequest
 * @package Paytic\Omnipay\Mobilpay\Message\Soap\Payment
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
