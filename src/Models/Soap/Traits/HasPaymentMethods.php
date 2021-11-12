<?php

namespace Paytic\Omnipay\Mobilpay\Models\Soap\Traits;

use Paytic\Omnipay\Mobilpay\Utils\Constants;

/**
 * Trait HasPaymentMethods
 * @package Paytic\Omnipay\Mobilpay\Models\Soap\Traits
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
