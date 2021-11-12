<?php

namespace Paytic\Omnipay\Mobilpay\Models;

use Paytic\Omnipay\Mobilpay\Models\Invoice\Item as InvoiceItem;
use DOMDocument;
use DOMNode;
use Exception;

/**
 * ClassInvoice
 * @copyright NETOPIA System
 * @author Claudiu Tudose
 * @version 1.0
 *
 */
class Invoice
{
    const ERROR_INVALID_PARAMETER = 0x11110001;
    const ERROR_INVALID_CURRENCY = 0x11110002;
    const ERROR_ITEM_INSERT_INVALID_INDEX = 0x11110003;

    const ERROR_LOAD_FROM_XML_CURRENCY_ATTR_MISSING = 0x31110001;

    public $currency = null;
    public $amount = null;
    public $details = null;
    public $installments = null;
    public $selectedInstallments = null;


    protected $billingAddress = null;
    protected $shippingAddress = null;

    protected $items = [];
    protected $exchangeRates = [];

    /**
     * Invoice constructor.
     * @param DOMNode|null $elem
     */
    public function __construct(DOMNode $elem = null)
    {
        if ($elem != null) {
            $this->loadFromXml($elem);
        }
    }

    /**
     * @param DOMNode|DOMDocument $elem
     * @throws Exception
     */
    protected function loadFromXml(DOMNode $elem)
    {
        $attr = $elem->attributes->getNamedItem('currency');
        if ($attr == null) {
            throw new Exception(
                'Mobilpay_Payment_Invoice::loadFromXml failed; currency attribute missing',
                self::ERROR_LOAD_FROM_XML_CURRENCY_ATTR_MISSING
            );
        }
        $this->currency = $attr->nodeValue;

        $attr = $elem->attributes->getNamedItem('amount');
        if ($attr != null) {
            $this->amount = $attr->nodeValue;
        }

        $attr = $elem->attributes->getNamedItem('installments');
        if ($attr != null) {
            $this->installments = $attr->nodeValue;
        }

        $attr = $elem->attributes->getNamedItem('selected_installments');
        if ($attr != null) {
            $this->selectedInstallments = $attr->nodeValue;
        }


        $elems = $elem->getElementsByTagName('details');
        if ($elems->length == 1) {
            $this->details = urldecode($elems->item(0)->nodeValue);
        }

        $elems = $elem->getElementsByTagName('contact_info');
        if ($elems->length == 1) {
            $addrElem = $elems->item(0);

            $elems = $addrElem->getElementsByTagName('billing');
            if ($elems->length == 1) {
                $this->billingAddress = new Address($elems->item(0));
            }

            $elems = $addrElem->getElementsByTagName('shipping');
            if ($elems->length == 1) {
                $this->shippingAddress = new Address($elems->item(0));
            }
        }

        $this->items = [];
        $elems = $elem->getElementsByTagName('items');
        if ($elems->length == 1) {
            $itemElems = $elems->item(0);
            $elems = $itemElems->getElementsByTagName('item');
            if ($elems->length > 0) {
                $amount = 0;
                foreach ($elems as $itemElem) {
                    try {
                        $objItem = new InvoiceItem($itemElem);
                        $this->items[] = $objItem;
                        $amount += $objItem->getTotalAmount();
                    } catch (Exception $e) {
                        $e = $e;
                        continue;
                    }
                }
                $this->amount = $amount;
            }
        }

        $this->exchangeRates = [];
        $elems = $elem->getElementsByTagName('exchange_rates');
        if ($elems->length == 1) {
            $rateElems = $elems->item(0);
            $elems = $rateElems->getElementsByTagName('rate');
            foreach ($elems as $rateElem) {
                try {
                    $objRate = new Mobilpay_Payment_Exchange_Rate($rateElem);
                    $this->exchangeRates[] = $objRate;
                } catch (Exception $e) {
                    $e = $e;
                    continue;
                }
            }
        }
    }

    /**
     * @param DOMDocument $xmlDoc
     * @return \DOMElement
     * @throws Exception
     */
    public function createXmlElement(DOMDocument $xmlDoc)
    {
        if (!($xmlDoc instanceof DOMDocument)) {
            throw new Exception('', self::ERROR_INVALID_PARAMETER);
        }

        $xmlInvElem = $xmlDoc->createElement('invoice');

        if ($this->currency == null) {
            throw new Exception('Invalid currency', self::ERROR_INVALID_CURRENCY);
        }

        $xmlAttr = $xmlDoc->createAttribute('currency');
        $xmlAttr->nodeValue = $this->currency;
        $xmlInvElem->appendChild($xmlAttr);

        if ($this->amount != null) {
            $xmlAttr = $xmlDoc->createAttribute('amount');
            $xmlAttr->nodeValue = sprintf('%.02f', doubleval($this->amount));
            $xmlInvElem->appendChild($xmlAttr);
        }

        if ($this->installments != null) {
            $xmlAttr = $xmlDoc->createAttribute('installments');
            $xmlAttr->nodeValue = $this->installments;
            $xmlInvElem->appendChild($xmlAttr);
        }

        if ($this->selectedInstallments != null) {
            $xmlAttr = $xmlDoc->createAttribute('selected_installments');
            $xmlAttr->nodeValue = $this->selectedInstallments;
            $xmlInvElem->appendChild($xmlAttr);
        }

        if ($this->details != null) {
            $xmlElem = $xmlDoc->createElement('details');
            $xmlElem->appendChild($xmlDoc->createCDATASection(urlencode($this->details)));
            $xmlInvElem->appendChild($xmlElem);
        }

        if (($this->billingAddress instanceof Address) || ($this->shippingAddress instanceof Address)) {
            $xmlAddr = null;
            if ($this->billingAddress instanceof Address) {
                try {
                    $xmlElem = $this->billingAddress->createXmlElement($xmlDoc, 'billing');
                    if ($xmlAddr == null) {
                        $xmlAddr = $xmlDoc->createElement('contact_info');
                    }
                    $xmlAddr->appendChild($xmlElem);
                } catch (Exception $e) {
                    $e = $e;
                }
            }
            if ($this->shippingAddress instanceof Address) {
                try {
                    $xmlElem = $this->shippingAddress->createXmlElement($xmlDoc, 'shipping');
                    if ($xmlAddr == null) {
                        $xmlAddr = $xmlDoc->createElement('contact_info');
                    }
                    $xmlAddr->appendChild($xmlElem);
                } catch (Exception $e) {
                    $e = $e;
                }
            }
            if ($xmlAddr != null) {
                $xmlInvElem->appendChild($xmlAddr);
            }
        }

        if (is_array($this->items) && sizeof($this->items) > 0) {
            $xmlItems = null;
            foreach ($this->items as $item) {
                if (!($item instanceof InvoiceItem)) {
                    continue;
                }
                try {
                    $xmlItem = $item->createXmlElement($xmlDoc);
                    if ($xmlItems == null) {
                        $xmlItems = $xmlDoc->createElement('items');
                    }
                    $xmlItems->appendChild($xmlItem);
                } catch (Exception $e) {
                    $e = $e;
                }
            }
            if ($xmlItems != null) {
                $xmlInvElem->appendChild($xmlItems);
            }
        }

        if (is_array($this->exchangeRates) && sizeof($this->exchangeRates) > 0) {
            $xmlRates = null;
            foreach ($this->exchangeRates as $rate) {
                if (!($rate instanceof Mobilpay_Payment_Exchange_Rate)) {
                    continue;
                }
                try {
                    $xmlRate = $rate->createXmlElement($xmlDoc);
                    if ($xmlRates == null) {
                        $xmlRates = $xmlDoc->createElement('items');
                    }
                    $xmlRates->appendChild($xmlRate);
                } catch (Exception $e) {
                    $e = $e;
                }
            }
            if ($xmlItems != null) {
                $xmlInvElem->appendChild($xmlRates);
            }
        }

        return $xmlInvElem;
    }

    /**
     * @return Address
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param Address $address
     * @return $this
     */
    public function setBillingAddress(Address $address)
    {
        $this->billingAddress = $address;

        return $this;
    }

    /**
     * @return Address
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param Address $address
     * @return $this
     */
    public function setShippingAddress(Address $address)
    {
        $this->shippingAddress = $address;

        return $this;
    }

    /**
     * @param InvoiceItem $item
     * @return $this
     */
    public function addHeadItem(Invoice\Item $item)
    {
        array_unshift($this->items, $item);

        return $this;
    }

    /**
     * @param InvoiceItem $item
     * @return $this
     */
    public function addTailItem(InvoiceItem $item)
    {
        array_push($this->items, $item);

        return $this;
    }

    /**
     * @return mixed
     */
    public function removeHeadItem()
    {
        return array_shift($this->items);
    }

    /**
     * @return mixed
     */
    public function removeTailItem()
    {
        return array_pop($this->items);
    }

    /**
     * @param Mobilpay_Payment_Exchange_Rate $rate
     * @return $this
     */
    public function addHeadExchangeRate(Mobilpay_Payment_Exchange_Rate $rate)
    {
        array_unshift($this->exchangeRates, $rate);

        return $this;
    }

    /**
     * @param Mobilpay_Payment_Exchange_Rate $rate
     * @return $this
     */
    public function addTailExchangeRate(Mobilpay_Payment_Exchange_Rate $rate)
    {
        array_push($this->exchangeRates, $rate);

        return $this;
    }

    /**
     * @return mixed
     */
    public function removeHeadExchangeRate()
    {
        return array_shift($this->exchangeRates);
    }

    /**
     * @return mixed
     */
    public function removeTailExchangeRate()
    {
        return array_pop($this->exchangeRates);
    }
}
