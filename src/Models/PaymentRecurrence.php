<?php

namespace Paytic\Omnipay\Mobilpay\Models;

use DOMDocument;
use DOMElement;
use Exception;

/**
 * Class PaymentRecurrence
 * @package Paytic\Omnipay\Mobilpay\Models
 */
class PaymentRecurrence
{
    const ERROR_INVALID_PARAMETER = 0x11110001;

    /**
     * @var int
     */
    protected $intervalDay;

    /**
     * @var int
     */
    protected $paymentsNo;

    /**
     * @return int
     */
    public function getIntervalDay(): int
    {
        return $this->intervalDay;
    }

    /**
     * @param int $intervalDay
     */
    public function setIntervalDay(int $intervalDay)
    {
        $this->intervalDay = $intervalDay;
    }

    /**
     * @return int
     */
    public function getPaymentsNo(): int
    {
        return $this->paymentsNo;
    }

    /**
     * @param int $paymentsNo
     */
    public function setPaymentsNo(int $paymentsNo)
    {
        $this->paymentsNo = $paymentsNo;
    }

    /**
     *
     * Returns the xml representation for this object. Appends the representation if $xmlDoc is provided
     * @param DOMDocument $xmlDoc
     * @return DOMElement
     * @throws Exception On invalid data
     */
    public function createXmlElement(DOMDocument $xmlDoc)
    {
        if (!($xmlDoc instanceof DOMDocument)) {
            throw new Exception('', self::ERROR_INVALID_PARAMETER);
        }

        $xmlElem = $xmlDoc->createElement('recurrence');

        $xmlAttr = $xmlDoc->createAttribute('payments_no');
        $xmlAttr->nodeValue = $this->paymentsNo;
        $xmlElem->appendChild($xmlAttr);

        $xmlAttr = $xmlDoc->createAttribute('interval_day');
        $xmlAttr->nodeValue = $this->intervalDay;
        $xmlElem->appendChild($xmlAttr);

        return $xmlElem;
    }
}
