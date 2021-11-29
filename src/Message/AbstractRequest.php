<?php

namespace Paytic\Omnipay\Mobilpay\Message;

use Paytic\Omnipay\Common\Message\Traits\SendDataRequestTrait;
use Paytic\Omnipay\Mobilpay\Utils\Traits\HasOrderId;
use Paytic\Omnipay\Mobilpay\Utils\Traits\HasSecurityParams;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;

/**
 * Class AbstractRequest
 * @package Paytic\Omnipay\Mobilpay\Message
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
