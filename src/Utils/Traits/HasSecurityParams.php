<?php

namespace Paytic\Omnipay\Mobilpay\Utils\Traits;

use Paytic\Omnipay\Mobilpay\Gateway;
use Paytic\Omnipay\Mobilpay\Message\AbstractRequest;
use Paytic\Omnipay\Mobilpay\Message\Soap\Payment\DoPayTRequest;

/**
 * Trait HasSecurityParams
 * @package Paytic\Omnipay\Mobilpay\Utils\Traits
 */
trait HasSecurityParams
{

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->getParameter('signature');
    }

    /**
     * @param mixed $value
     */
    public function setSignature($value)
    {
        return $this->setParameter('signature', $value);
    }

    /**
     * @return null|string
     */
    public function getCertificate()
    {
        return $this->getParameter('certificate');
    }

    /**
     * @param null|string $value
     */
    public function setCertificate($value)
    {
        return $this->setParameterWithFileCheck($value, 'certificate');
    }

    /**
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    /**
     * @param string $value
     */
    public function setPrivateKey($value)
    {
        return $this->setParameterWithFileCheck($value, 'privateKey');
    }

    /**
     * @param $value
     * @param $parameter
     * @return Gateway|AbstractRequest|DoPayTRequest
     */
    protected function setParameterWithFileCheck($value, $parameter)
    {
        if ($value && !empty($value) && file_exists($value)) {
            $value = file_get_contents($value);
        }

        return $this->setParameter($parameter, $value);
    }
}
