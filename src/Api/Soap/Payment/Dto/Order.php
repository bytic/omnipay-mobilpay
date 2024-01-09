<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto;

use stdClass;

/**
 *
 */
class Order extends stdClass
{
    //your orderId. As with all mobilPay payments, it needs to be unique at seller account level
    public $id = '';

    //payment descriptor
    public $description = '';

    // order amount; decimals present only when necessary, i.e. 15 not 15.00
    public float $amount = 0;

    //currency of the payment
    public $currency = '';

    public ?Party $billing = null;
//    public ?Party $shipping = null;


}