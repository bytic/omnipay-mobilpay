<?php

namespace ByTIC\Omnipay\Mobilpay\Message\Soap\Payment;

use ByTIC\Omnipay\Mobilpay\Message\Soap\SoapResponse;
use ByTIC\Omnipay\Mobilpay\Utils\Traits\HasAuthTrait;
use ByTIC\Omnipay\Mobilpay\Utils\Traits\HasOrderId;
use ByTIC\Omnipay\Mobilpay\Utils\Traits\HasSecurityParams;
use stdClass;

/**
 * Class DoPayTRequest
 * @package ByTIC\Omnipay\Mobilpay\Message\Soap\Payment
 */
class DoPayTRequest extends AbstractPaymentSoapRequest
{
    use HasAuthTrait;
    use HasSecurityParams;
    use HasOrderId;

    /**
     * @inheritDoc
     */
    protected function runTransaction($soapClient, $data)
    {
        return $this->runSoapTransaction($soapClient, 'doPayT', $data);
    }

    public function getData()
    {
        $this->validate(
            'username',
            'password',
            'signature',
            'privateKey',
            'amount',
            'orderId'
        );

        return [
            'request' => $this->buildRequest(),
        ];
    }

    protected function buildRequest(): stdClass
    {
        $request = new stdClass();

        $account = $this->buildAccount();
        $order = $this->buildOrder();

        $account->hash = strtoupper(
            sha1(
                strtoupper(
                    md5($this->getPassword())
                )."{$order->id}{$order->amount}{$order->currency}{$account->id}"
            )
        );

        $request->account = $account;
        $request->order = $order;
        $request->params = $this->buildParams();
        $request->transaction = $this->buildTransaction();

        return $request;
    }

    protected function buildAccount(): stdClass
    {
        $account = new stdClass();
        $account->id = $this->getSignature();

        //please ask mobilPay to upgrade the necessary access required for token payments
        $account->user_name = $this->getUsername();

        //the IP address of the buyer.
        $account->customer_ip = $this->getClientIp();

        //this is where mobilPay will send the payment result. This has priority over the SOAP call response
        $account->confirm_url = ''.$this->getNotifyUrl();

        return $account;
    }

    protected function buildParams(): stdClass
    {
        $params = new stdClass();
        $params->item = new stdClass();
        $params->item->name = 'param1name';
        $params->item->value = 'param1value';
        return $params;
    }

    protected function buildOrder(): stdClass
    {
        $card = $this->getCard();
        $billing = new stdClass();
        $billing->country = '';
        $billing->county = '';
        $billing->city = '';
        $billing->address = $card->getBillingAddress1().' '.$card->getBillingAddress2();
        $billing->postal_code = '';
        $billing->first_name = $card->getBillingFirstName();
        $billing->last_name = $card->getBillingLastName();
        $billing->phone = $card->getBillingPhone();
        $billing->email = $card->getEmail();
        /*
            $shipping = new stdClass();
            $shipping->country = 'shipping_country';
            $shipping->county = 'shipping_county';
            $shipping->city = 'shipping_city';
            $shipping->address = 'shipping_address';
            $shipping->postal_code = 'shipping_postal_code';
            $shipping->first_name = 'shipping_first_name';
            $shipping->last_name = 'shipping_last_name';
            $shipping->phone = 'shipping_phone';
            $shipping->email = 'shipping_email';
        */

        $order = new stdClass();
        //your orderId. As with all mobilPay payments, it needs to be unique at seller account level
        $order->id = $this->getOrderId();

        //payment descriptor
        $order->description = $this->getDescription();

        // order amount; decimals present only when necessary, i.e. 15 not 15.00
        $order->amount = floatval($this->getAmount());
        $order->currency = $this->getCurrency();
        $order->billing = $billing;

        //  $order->shipping = $shipping;
        return $order;
    }

    protected function buildTransaction(): stdClass
    {
        $transaction = new stdClass();

        //you will receive this token together with its expiration date following a standard payment.
        // Please store and use this token with maximum care
        $transaction->paymentToken = $this->getToken();

        return $transaction;
    }

    /**
     * @return string
     */
    protected function getResponseClass()
    {
        return DoPayTResponse::class;
    }
}
