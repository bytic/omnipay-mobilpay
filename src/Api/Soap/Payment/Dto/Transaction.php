<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto;

use stdClass;

/**
 *
 */
class Transaction extends stdClass
{
    //you will receive this token together with its expiration date following a standard payment.
    // Please store and use this token with maximum care
    public string $paymentToken;

    /**
     * @param $token
     * @return self
     */
    public static function fromToken($token): self
    {
        $transaction = new self();
        $transaction->paymentToken = $token;

        return $transaction;
    }
}