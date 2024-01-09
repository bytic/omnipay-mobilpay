<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Factory;

use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Actions\HashRequest;
use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto\Request;
use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto\Transaction;
use Paytic\Omnipay\Mobilpay\Message\Soap\Payment\DoPayTRequest;
use stdClass;

/**
 *
 */
class RequestFactory
{
    protected DoPayTRequest $requestMessage;

    /**
     * @param DoPayTRequest $requestMessage
     */
    public function __construct(DoPayTRequest $requestMessage)
    {
        $this->requestMessage = $requestMessage;
    }

    public function build(): Request
    {
        $request = new Request();

        $request->order = OrderFactory::fromMessage($this->requestMessage)->build();

        $request->account = AccountFactory::fromMessage($this->requestMessage)->build();
        $request->account->hash = HashRequest::fromRequest($request, $this->requestMessage->getPassword());

        $request->transaction = Transaction::fromToken($this->requestMessage->getToken());

        $request->params = $this->buildParams();

        return $request;
    }

    public static function fromMessage(DoPayTRequest $requestMessage): self
    {
        return new static($requestMessage);
    }

    protected function buildParams(): stdClass
    {
        $params = new stdClass();
        $params->item = new stdClass();
        $params->item->name = 'param1name';
        $params->item->value = 'param1value';

        return $params;
    }
}
