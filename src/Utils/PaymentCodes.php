<?php

namespace ByTIC\Omnipay\Mobilpay\Utils;

/**
 * Class PaymentCodes
 * @package ByTIC\Omnipay\Mobilpay\Utils
 */
class PaymentCodes
{
    public const APPROVED = '0';
    // (I.E. STOLEN CARD)
    public const CARD_HAS_A_RISK = '16';
    public const CARD_NUMBER_IS_INCORRECT = '17';
    public const CLOSED_CARD = '18';
    public const CARD_IS_EXPIRED = '19';
    public const INSUFFICIENT_FUNDS = '20';
    public const CVV2_CODE_INCORRECT = '21';
    public const ISSUER_IS_UNAVAILABLE = '22';
    public const AMOUNT_IS_INCORRECT = '32';
    public const CURRENCY_IS_INCORRECT = '33';
    public const TRANSACTION_NOT_PERMITTED_TO_CARDHOLDER = '34';
    public const TRANSACTION_DECLINED_35 = '35';
    public const TRANSACTION_REJECTED_ANTIFRAUD = '36';

    //(BREAKING_THE_LAW)
    public const TRANSACTION_DECLINED_LAW = '37';
    public const TRANSACTION_DECLINED = '38';
    public const INVALID_REQUEST = '48';
    public const DUPLICATE_PREAUTH = '49';
    public const DUPLICATE_AUTH = '50';
    public const YOU_CAN_ONLY_CANCEL_A_PREAUTH_ORDER = '51';
    public const YOU_CAN_ONLY_CONFIRM_A_PREAUTH_ORDER = '52';
    public const YOU_CAN_ONLY_CREDIT_A_CONFIRMED_ORDER = '53';
    public const CREDIT_AMOUNT_HIGHER_THAN_AUTH = '54';
    public const CAPTURE_AMOUNT_HIGHER_THAN_PREAUTH = '55';
    public const DUPLICATE_REQUEST = '56';
    public const GENERIC_ERROR = '99';
}
