<?php

namespace ByTIC\Omnipay\Mobilpay\Message;

use ByTIC\Omnipay\Common\Message\Traits\SendDataRequestTrait;
use Omnipay\Common\Message\AbstractRequest as CommonAbstractRequest;

/**
 * Class AbstractRequest
 * @package ByTIC\Omnipay\Mobilpay\Message
 */
abstract class AbstractRequest extends CommonAbstractRequest
{
    use SendDataRequestTrait;

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->getParameter('signature');
    }

    /**
     * @param $value
     * @return CommonAbstractRequest
     */
    public function setSignature($value)
    {
        return $this->setParameter('signature', $value);
    }

    /**
     * @return mixed
     */
    public function getCertificate()
    {
        return $this->getParameter('certificate');
    }

    /**
     * @param $value
     * @return CommonAbstractRequest
     */
    public function setCertificate($value)
    {
        return $this->setParameter('certificate', $value);
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    /**
     * @param $value
     * @return CommonAbstractRequest
     */
    public function setPrivateKey($value)
    {
        return $this->setParameter('privateKey', $value);
    }

    /**
     * @return mixed
     */
    public function getEndpointUrl()
    {
        return $this->getParameter('endpointUrl');
    }

    /**
     * @param $value
     * @return CommonAbstractRequest
     */
    public function setEndpointUrl($value)
    {
        return $this->setParameter('endpointUrl', $value);
    }
    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    /**
     * @param  string $value
     * @return mixed
     */
    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }
}
