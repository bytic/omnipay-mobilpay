<?php

namespace Paytic\Omnipay\Mobilpay\Message;

use Paytic\Omnipay\Common\Message\Traits\HtmlResponses\ConfirmHtmlTrait;

/**
 * Class PurchaseResponse
 * @package ByTIC\Common\Payments\Gateways\Providers\AbstractGateway\Messages
 */
class CompletePurchaseResponse extends AbstractResponse
{
    use ConfirmHtmlTrait;
}
