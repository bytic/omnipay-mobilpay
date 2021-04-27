<?php

namespace ByTIC\Omnipay\Mobilpay\Message\Soap\Merchant;

use ByTIC\Omnipay\Mobilpay\Message\Soap\AbstractSoapRequest;
use ByTIC\Omnipay\Mobilpay\Utils\Traits\HasAuthTrait;

/**
 * Class RegisterCompanyRequest
 * @package ByTIC\Omnipay\Mobilpay\Message\Soap
 */
class LogInRequest extends AbstractSoapRequest
{
    use HasAuthTrait;

    /**
     * @inheritDoc
     */
    protected function runTransaction($soapClient, $data)
    {
        return $this->runSoapTransaction($soapClient, 'logIn', $data);
    }

    /**
     * @inheritDoc
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('username', 'password');

        return [
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
        ];
    }
}
