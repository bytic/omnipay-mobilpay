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
    public function getSiteId()
    {
        return $this->getParameter('siteId');
    }

    /**
     * @param $value
     * @return CommonAbstractRequest
     */
    public function setSiteId($value)
    {
        return $this->setParameter('siteId', $value);
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * @param $value
     * @return CommonAbstractRequest
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->getParameter('apiUrl');
    }

    /**
     * @param $value
     * @return CommonAbstractRequest
     */
    public function setApiUrl($value)
    {
        return $this->setParameter('apiUrl', $value);
    }

    /**
     * @return mixed
     */
    public function getSecureUrl()
    {
        return $this->getParameter('secureUrl');
    }

    /**
     * @param $value
     * @return CommonAbstractRequest
     */
    public function setSecureUrl($value)
    {
        return $this->setParameter('secureUrl', $value);
    }
}
