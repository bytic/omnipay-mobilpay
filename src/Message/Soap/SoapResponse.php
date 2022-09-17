<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Message\Soap;

/**
 * Class SoapResponse
 * @package Paytic\Omnipay\Mobilpay\Message\Soap
 */
class SoapResponse extends AbstractSoapResponse
{

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return false;
    }
}
