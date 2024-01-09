<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto;

use stdClass;

/**
 *
 */
class Account extends stdClass
{
    // Can be obtained from mobilPay's merchant console and has to look like XXXX-YYYY-ZZZZ-TTTT
    public string $id = '';

    //please ask mobilPay to upgrade the necessary access required for token payments
    public string $user_name = '';

    //the IP address of the buyer.
    public ?string $customer_ip = null;

    //this is where mobilPay will send the payment result. This has priority over the SOAP call response
    public string $confirm_url = '';

    public string $hash = '';
}