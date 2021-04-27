<?php

namespace ByTIC\Omnipay\Mobilpay\Message;

use ByTIC\Omnipay\Common\Message\Traits\SendDataRequestTrait;
use ByTIC\Omnipay\Mobilpay\Utils\Traits\HasOrderId;
use ByTIC\Omnipay\Mobilpay\Utils\Traits\HasSecurityParams;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;

/**
 * Class AbstractRequest
 * @package ByTIC\Omnipay\Mobilpay\Message
 */
abstract class AbstractRequest extends OmnipayAbstractRequest
{
    use SendDataRequestTrait;
    use HasSecurityParams;
    use HasOrderId;

    /**
     * @return mixed
     */
    public function getEndpointUrl()
    {
        return $this->getParameter('endpointUrl');
    }

    /**
     * @param $value
     * @return OmnipayAbstractRequest
     */
    public function setEndpointUrl($value)
    {
        return $this->setParameter('endpointUrl', $value);
    }
}
