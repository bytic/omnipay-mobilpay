<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto;

use stdClass;

class Party extends stdClass
{
    public $country = '';
    public $county = '';
    public $city = '';
    public $address = '';
    public $postal_code = '';
    public $first_name = '';
    public $last_name = '';
    public $phone = '';
    public $email = '';
}