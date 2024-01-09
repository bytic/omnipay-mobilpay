<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto;

use stdClass;

/**
 *
 */
class Request extends stdClass
{
    public $account;

    public $order;

    public $params;

    public ?Transaction $transaction = null;

}

