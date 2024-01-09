<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Factory;

use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto\Account;
use Paytic\Omnipay\Mobilpay\Message\Soap\Payment\DoPayTRequest;

/**
 *
 */
class AccountFactory
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

    public function build(): Account
    {
        $account = new Account();
        $account->id = $this->requestMessage->getSignature();
        $account->user_name = $this->requestMessage->getUsername();
        $account->customer_ip = $this->requestMessage->getClientIp();
        $account->confirm_url = ''.$this->requestMessage->getNotifyUrl();

        return $account;
    }
}
