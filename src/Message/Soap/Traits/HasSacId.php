<?php

namespace Paytic\Omnipay\Mobilpay\Message\Soap\Traits;

/**
 * Trait HasSacId
 * @package Paytic\Omnipay\Mobilpay\Message\Soap\Traits
 */
trait HasSacId
{

    /**
     * @return mixed
     */
    public function getSacId()
    {
        return $this->getParameter('sacId');
    }

    /**
     * @param string $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setSacId($value)
    {
        return $this->setParameter('sacId', $value);
    }
}
