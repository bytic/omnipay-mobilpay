<?php

namespace ByTIC\Omnipay\Mobilpay\Message\Soap\Merchant;

use ByTIC\Omnipay\Mobilpay\Message\Soap\AbstractSoapRequest;

/**
 * Class RegisterCompanyRequest
 * @package ByTIC\Omnipay\Mobilpay\Message\Soap
 */
class LogInRequest extends AbstractSoapRequest
{

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

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * @param string $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * @param string $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }
}
