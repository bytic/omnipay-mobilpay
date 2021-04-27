<?php

namespace ByTIC\Omnipay\Mobilpay\Message\Soap\Traits;

/**
 * Trait HasOrderId
 * @package ByTIC\Omnipay\Mobilpay\Message\Soap\Traits
 */
trait HasOrderId
{

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    /**
     * @param string $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }
}
