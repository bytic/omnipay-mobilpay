<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Factory;

use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto\Order;
use Paytic\Omnipay\Mobilpay\Message\Soap\Payment\DoPayTRequest;

/**
 *
 */
class OrderFactory
{

    protected DoPayTRequest $requestMessage;

    public function __construct(DoPayTRequest $requestMessage)
    {
        $this->requestMessage = $requestMessage;
    }

    public static function fromMessage(DoPayTRequest $requestMessage): self
    {
        return new static($requestMessage);
    }

    public function build(): Order
    {
        $card = $this->requestMessage->getCard();

        $order = new Order();
        $order->id = $this->requestMessage->getOrderId();

        $order->description = $this->requestMessage->getDescription();

        $order->amount = floatval($this->requestMessage->getAmount());
        $order->currency = $this->requestMessage->getCurrency();
        $order->billing = PartyFactory::billingFromCard($card);

        //  $order->shipping = $shipping;
        return $order;
    }
}