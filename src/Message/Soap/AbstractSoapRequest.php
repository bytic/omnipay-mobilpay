<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Message\Soap;

use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
use Paytic\Omnipay\Common\Message\Traits\Soap\AbstractSoapRequestTrait;
use Paytic\Omnipay\Mobilpay\Utils\Settings;

/**
 * Class SoapAbstractRequest
 * @package Paytic\Omnipay\Mobilpay\Message\Soap
 */
abstract class AbstractSoapRequest extends OmnipayAbstractRequest
{
    use AbstractSoapRequestTrait;

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return Settings::SOAP_MERCHANT_LIVE;
    }

    /**
     * @return string
     */
    protected function getResponseClass()
    {
        return SoapResponse::class;
    }
}
