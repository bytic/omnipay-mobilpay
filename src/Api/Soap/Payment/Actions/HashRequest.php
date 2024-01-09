<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Actions;

use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto\Request;

/**
 * The hash that has to be sent along with the other credentials has to be calculated as
 * follows:
 * hashPassword = strtoupper(md5(usrPassword));
 * //usrPassword is the same used to log into the merchant console for the user
 * performing the call
 * requestHashString="{hashPassword}{orderId}{orderAmount}{orderCurrency}{cardNumber}
 * {account id}";
 * //where hashPassword - the one obtained above
 * //orderID - merchant order ID - ‘Soap_Type_Payment_Order/id’
 * //orderAmount - amount as sent in the ‘Soap_Type_Payment_Order/amount’ field
 * //orderCurrency - currency ‘Soap_Type_Payment_Order/currency’
 * //account id - Soap_Type_Payment_Account/id
 * requeshHash=strtoupper(sha1(requestHashString));
 */
class HashRequest
{
    protected Request $request;

    protected string $password;

    /**
     * HashRequest constructor.
     * @param Request $request
     * @param string $password
     */
    public function __construct(Request $request, string $password)
    {
        $this->request = $request;
        $this->password = $password;
    }

    public static function fromRequest(Request $request, string $password): self
    {
        return new static($request, $password);
    }

    public function calculate(): string
    {
        $hashPassword = strtoupper(md5($this->password));
        $order = $this->request->order;
        $account = $this->request->account;
        $requestHashString = "{$hashPassword}{$order->id}{$order->amount}{$order->currency}{$account->id}";

        return strtoupper(sha1($requestHashString));
    }
}
