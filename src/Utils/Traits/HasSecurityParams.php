<?php

namespace ByTIC\Omnipay\Mobilpay\Utils\Traits;

/**
 * Trait HasSecurityParams
 * @package ByTIC\Omnipay\Mobilpay\Utils\Traits
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
        if (file_exists($value)) {
            $value = file_get_contents($value);
        }
        return $this->setParameter('certificate', $value);
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
        if (file_exists($value)) {
            $value = file_get_contents($value);
        }
        return $this->setParameter('privateKey', $value);
    }
}