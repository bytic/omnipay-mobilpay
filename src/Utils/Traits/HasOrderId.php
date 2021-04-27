<?php

namespace ByTIC\Omnipay\Mobilpay\Utils\Traits;

/**
 * Trait HasOrderId
 * @package ByTIC\Omnipay\Mobilpay\Utils\Traits
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
