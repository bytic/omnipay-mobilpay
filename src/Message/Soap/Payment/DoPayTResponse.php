<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Message\Soap\Payment;

use Paytic\Omnipay\Mobilpay\Message\Soap\SoapResponse;

/**
 * Class DoPayTResponse
 * @package Paytic\Omnipay\Mobilpay\Message\Soap\Payment
 */
class DoPayTResponse extends SoapResponse
{
    public function isSuccessful(): bool
    {
        if (isset($this->data['doPayTResult']['errors']['action'])) {
            return $this->data['doPayTResult']['errors']['action'] == 'confirmed';
        }

        return parent::isSuccessful();
    }

    /**
     * @inheritDoc
     */
    public function getCode()
    {
        if (isset($this->data['doPayTResult']['errors']['code'])) {
            return $this->data['doPayTResult']['errors']['code'];
        }

        return parent::getCode();
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        if (isset($this->data['doPayTResult']['errors']['message'])) {
            $message = $this->data['doPayTResult']['errors']['message'];
            if (isset($this->data['doPayTResult']['errors']['details'])) {
                $message .= ': '.print_r($this->data['doPayTResult']['errors']['details'], true);
            }

            return $message;
        }

        return parent::getCode();
    }

    /**
     * @inheritDoc
     */
    public function getTransactionId()
    {
        if (isset($this->data['doPayTResult']['order']['id'])) {
            return $this->data['doPayTResult']['order']['id'];
        }

        return parent::getTransactionId();
    }

    /**
     * @inheritDoc
     */
    public function getTransactionReference()
    {
        if (isset($this->data->doPayTResult->transaction->id)) {
            return $this->data->doPayTResult->transaction->id;
        }

        return parent::getTransactionReference();
    }
}
