<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Factory;

use Omnipay\Common\CreditCard;
use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto\Party;

/**
 *
 */
class PartyFactory
{

    public static function billingFromCard(CreditCard $card): Party
    {
        $billing = new Party();
        $billing->country = '';
        $billing->county = '';
        $billing->city = '';
        $billing->address = $card->getBillingAddress1().' '.$card->getBillingAddress2();
        $billing->postal_code = '';
        $billing->first_name = $card->getBillingFirstName();
        $billing->last_name = $card->getBillingLastName();
        $billing->phone = $card->getBillingPhone();
        $billing->email = $card->getEmail();

        return $billing;
    }
}