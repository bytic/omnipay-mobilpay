<?php

namespace Paytic\Omnipay\Mobilpay\Models\Request;

use DOMDocument;
use DOMElement;
use Exception;

/**
 * Class Mobilpay_Payment_Request_Sms
 * This class can be used for accessing mobilpay.ro payment interface for your configured online services
 * @copyright NETOPIA System
 * @author Claudiu Tudose
 * @version 1.0
 *
 */
class Sms extends AbstractRequest
{
    const ERROR_LOAD_FROM_XML_SERVICE_ELEM_MISSING = 0x31000001;
    /**
     * mobilePhone    (Optional)        - MSISDN (mobile phone numner) of the customer.
     * If it's supplied it should be in 07XXXXXXXX format.
     * If it's supplied mobilpay.ro will autocomplete mobile phone field on payment interface
     *
     * @var string(10)
     */
    public $msisdn = null;

    /**
     * Sms constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->type = self::PAYMENT_TYPE_SMS;
    }

    /**
     * @param DOMElement $elem
     * @return $this
     * @throws Exception
     */
    protected function loadFromXml(DOMElement $elem)
    {
        parent::parseFromXml($elem);

        //SMS request specific data
        $elems = $elem->getElementsByTagName('service');
        if ($elems->length != 1) {
            throw new Exception(
                'Mobilpay_Payment_Request_Sms::loadFromXml failed: service is missing',
                self::ERROR_LOAD_FROM_XML_SERVICE_ELEM_MISSING
            );
        }
        $xmlElem = $elems->item(0);
        $this->service = $xmlElem->nodeValue;

        $elems = $elem->getElementsByTagName('msisdn');
        if ($elems->length == 1) {
            $this->msisdn = $elems->item(0)->nodeValue;
        }

        $elem = $elem;

        return $this;
    }

    /**
     * @param $queryString
     * @return $this
     * @throws Exception
     */
    protected function loadFromQueryString($queryString)
    {
        $parameters = explode('&', $queryString);
        $reqParams = [];
        foreach ($parameters as $item) {
            list($key, $value) = explode('=', $item);
            $reqParams[$key] = urldecode($value);
        }

        if (!isset($reqParams['signature'])) {
            throw new Exception(
                'Mobilpay_Payment_Request_Sms::loadFromQueryString failed: signature is missing',
                self::ERROR_LOAD_FROM_XML_SIGNATURE_ELEM_MISSING
            );
        }
        $this->signature = $reqParams['signature'];
        if (!isset($reqParams['service'])) {
            throw new Exception(
                'Mobilpay_Payment_Request_Sms::loadFromQueryString failed: service is missing',
                self::ERROR_LOAD_FROM_XML_SERVICE_ELEM_MISSING
            );
        }
        $this->service = $reqParams['service'];
        if (!isset($reqParams['tran_id'])) {
            throw new Exception(
                'Mobilpay_Payment_Request_Sms::loadFromQueryString failed: empty order id',
                self::ERROR_LOAD_FROM_XML_ORDER_ID_ATTR_MISSING
            );
        }
        $this->orderId = $reqParams['tran_id'];
        if (isset($reqParams['timestamp'])) {
            $this->timestamp = $reqParams['timestamp'];
        }
        if (isset($reqParams['confirm_url'])) {
            $this->confirmUrl = $reqParams['confirm_url'];
        }
        if (isset($reqParams['return_url'])) {
            $this->confirmUrl = $reqParams['return_url'];
        }
        if (isset($reqParams['msisdn'])) {
            $this->msisdn = $reqParams['msisdn'];
        }
        if (isset($reqParams['first_name'])) {
            $this->params['first_name'] = $reqParams['first_name'];
        }
        if (isset($reqParams['last_name'])) {
            $this->params['last_name'] = $reqParams['last_name'];
        }

        return $this;
    }

    /**
     * @return mixed
     */
    protected function prepare()
    {
        if (is_null($this->signature) || is_null($this->service) || is_null($this->orderId)) {
            throw new Exception(
                'One or more mandatory properties are invalid!',
                self::ERROR_PREPARE_MANDATORY_PROPERTIES_UNSET
            );
        }

        $rootElem = $this->initXmlOrderDocument();

        if (!is_null($this->msisdn)) {
            $xmlElem = $this->xmlDoc->createElement('msisdn');
            $xmlElem->nodeValue = $this->msisdn;
            $rootElem->appendChild($xmlElem);
        }

        $this->appendXmlParams($rootElem);
        $this->appendReturnUrl($rootElem);

        $this->xmlDoc->appendChild($rootElem);

        return $this;
    }
}
