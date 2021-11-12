<?php

namespace Paytic\Omnipay\Mobilpay\Utils;

/**
 * Class Settings
 * @package Paytic\Omnipay\Mobilpay
 */
class Settings
{
    const ENDPOINT_SANDBOX = 'http://sandboxsecure.mobilpay.ro';
    const ENDPOINT_LIVE = 'https://secure.mobilpay.ro';

    const SOAP_MERCHANT_LIVE = 'http://www.mobilpay.ro/api/merchant?wsdl';
    const SOAP_MERCHANT_SANDBOX = 'http://sandboxsecure.mobilpay.ro/api/merchant?wsdl';

    const SOAP_PAYMENT_LIVE = 'https://secure.mobilpay.ro/api/payment2/?wsdl';
    const SOAP_PAYMENT_SANDBOX = 'http://sandboxsecure.mobilpay.ro/api/payment2/?wsdl';
}
