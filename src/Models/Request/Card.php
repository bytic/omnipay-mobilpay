<?php

namespace ByTIC\Omnipay\Mobilpay\Models\Request;

use ByTIC\Omnipay\Mobilpay\Models\Invoice;
use ByTIC\Omnipay\Mobilpay\Models\PaymentSplit;
use DOMElement;
use Exception;

/**
 * Class Mobilpay_Payment_Request_Card
 * This class can be used for accessing mobilpay.ro payment interface for your configured online services
 * @copyright NETOPIA System
 * @author Claudiu Tudose
 * @version 1.0
 *
 */
class Card extends AbstractRequest
{
    const ERROR_LOAD_FROM_XML_ORDER_INVOICE_ELEM_MISSING = 0x30000001;

    /**
     *
     * customer types
     * @var integer
     */
    const CUSTOMER_TYPE_MERCHANT = 0x01;
    const CUSTOMER_TYPE_MOBILPAY = 0x02;

    /**
     * @var Invoice
     */
    public $invoice = null;

    /**
     *
     * recurrent informations object
     * @var Mobilpay_Payment_Recurrence
     */
    public $recurrence = null;

    /**
     * split informations
     * @var PaymentSplit
     */
    public $split = null;


    /**
     * paymentInstrument
     */
    public $paymentInstrument = null;

    /**
     * AbstractRequest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->type = self::PAYMENT_TYPE_CARD;
    }

    /**
     * @param DOMElement $elem
     * @return $this
     * @throws Exception
     */
    protected function loadFromXml(DOMElement $elem)
    {
        parent::parseFromXml($elem);

        $this->loadFromXmlInvoice($elem);
        $this->loadFromXmlRecurrence($elem);
        $this->loadFromXmlPaymentSplit($elem);
        $this->loadFromXmlPaymentInstrument($elem);

        return $this;
    }

    /**
     * @param DOMElement $elem
     * @throws Exception
     */
    protected function loadFromXmlInvoice(DOMElement $elem)
    {
        //card request specific data
        $itemElements = $elem->getElementsByTagName('invoice');
        if ($itemElements->length != 1) {
            throw new Exception(
                'Mobilpay_Payment_Request_Card::loadFromXml failed; invoice element is missing',
                self::ERROR_LOAD_FROM_XML_ORDER_INVOICE_ELEM_MISSING
            );
        }
        $this->invoice = new Invoice($itemElements->item(0));
    }

    /**
     * @param DOMElement $elem
     * @throws Exception
     */
    protected function loadFromXmlRecurrence(DOMElement $elem)
    {
//        $itemElements = $elem->getElementsByTagName('recurrence');
//        if ($itemElements->length > 0) {
//            $this->recurrence = new Mobilpay_Payment_Recurrence($itemElements->item(0));
//        }
    }

    /**
     * @param DOMElement $elem
     * @throws Exception
     */
    protected function loadFromXmlPaymentSplit(DOMElement $elem)
    {
        $itemElements = $elem->getElementsByTagName('split');
        if ($itemElements->length > 0) {
            $this->split = new PaymentSplit($itemElements->item(0));
        }
    }

    /**
     * @param DOMElement $elem
     * @throws Exception
     */
    protected function loadFromXmlPaymentInstrument(DOMElement $elem)
    {
//        $itemElements = $elem->getElementsByTagName('payment_instrument');
//        if ($itemElements->length > 0) {
//            $this->paymentInstrument = new Mobilpay_Payment_Instrument_Card($itemElements->item(0));
//        }
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function prepare()
    {
        if (is_null($this->signature) || is_null($this->orderId) || !($this->invoice instanceof Invoice)) {
            throw new Exception(
                'One or more mandatory properties are invalid!',
                self::ERROR_PREPARE_MANDATORY_PROPERTIES_UNSET
            );
        }

        $rootElem = $this->initXmlOrderDocument();
        $this->appendXmlInvoice($rootElem);
        $this->appendXmlRecurrence($rootElem);
        $this->appendXmlPaymentSplit($rootElem);
        $this->appendPaymentInstrument($rootElem);
        $this->appendXmlParams($rootElem);
        $this->appendReturnUrl($rootElem);

        $this->xmlDoc->appendChild($rootElem);

        return $this;
    }

    /**
     * @param DOMElement $rootElem
     * @throws Exception
     */
    protected function appendXmlInvoice($rootElem)
    {
        $xmlElem = $this->invoice->createXmlElement($this->xmlDoc);
        $rootElem->appendChild($xmlElem);
    }


    /**
     * @param DOMElement $rootElem
     * @throws Exception
     */
    protected function appendXmlRecurrence($rootElem)
    {
//        if ($this->recurrence instanceof Mobilpay_Payment_Recurrence) {
//            $xmlElem = $this->recurrence->createXmlElement($this->xmlDoc);
//            $rootElem->appendChild($xmlElem);
//        }
    }

    /**
     * @param DOMElement $rootElem
     * @throws Exception
     */
    protected function appendXmlPaymentSplit($rootElem)
    {
        if ($this->split instanceof PaymentSplit) {
            $xmlSplit = $this->xmlDoc->createElement('split');
            $xmlElements = $this->split->createXmlElement($this->xmlDoc);
            foreach ($xmlElements as $xmlElem) {
                $xmlSplit->appendChild($xmlElem);
            }
            $rootElem->appendChild($xmlSplit);
        }
    }

    /**
     * @param DOMElement $rootElem
     * @throws Exception
     */
    protected function appendPaymentInstrument($rootElem)
    {
//        if ($this->paymentInstrument instanceof Mobilpay_Payment_Instrument_Card) {
//            $xmlElem = $this->_xmlDoc->createElement('payment_instrument');
//            $xmlElem2 = $this->paymentInstrument->createXmlElement($this->_xmlDoc);
//            $xmlElem->appendChild($xmlElem2);
//            $rootElem->appendChild($xmlElem);
//        }
    }
}
