<?php

namespace ByTIC\Omnipay\Mobilpay\Models\Soap\Traits;

use ByTIC\Omnipay\Mobilpay\Utils\Constants;

/**
 * Trait HasPaymentMethods
 * @package ByTIC\Omnipay\Mobilpay\Models\Soap\Traits
 */
trait HasPaymentMethods
{
    protected $payment_methods = [Constants::PAYMENT_METHODS_CREDIT_CARD];

    /**
     * @return array
     */
    public function getPaymentMethods(): array
    {
        return $this->payment_methods;
    }

    /**
     * @param array $payment_methods
     */
    public function setPaymentMethods(array $payment_methods)
    {
        $this->payment_methods = $payment_methods;
    }
}
