<?php

namespace Paytic\Omnipay\Mobilpay\Utils\Traits;

/**
 * Trait HasAuthTrait
 * @package Paytic\Omnipay\Mobilpay\Utils\Traits
 */
trait HasAuthTrait
{

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
