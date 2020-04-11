<?php

namespace ByTIC\Omnipay\Mobilpay\Models\Request\Traits;

use DOMDocument;

/**
 * Trait HasXmlDocument
 * @package ByTIC\Omnipay\Mobilpay\Models\Request
 */
trait HasXmlDocument
{

    /**
     * @var null|DOMDocument
     */
    protected $xmlDoc = null;

    protected function initXmlDOMDocument()
    {
        $this->xmlDoc = new DOMDocument('1.0', 'utf-8');
    }

    /**
     * @return \DOMElement
     */
    protected function initXmlOrderDocument()
    {
        $this->initXmlDOMDocument();
        $rootElem = $this->xmlDoc->createElement('order');

        //set payment type attribute
        $xmlAttr = $this->xmlDoc->createAttribute('type');
        $xmlAttr->nodeValue = $this->type;
        $rootElem->appendChild($xmlAttr);

        //set id attribute
        $xmlAttr = $this->xmlDoc->createAttribute('id');
        $xmlAttr->nodeValue = $this->orderId;
        $rootElem->appendChild($xmlAttr);

        //set timestamp attribute
        $xmlAttr = $this->xmlDoc->createAttribute('timestamp');
        $xmlAttr->nodeValue = date('YmdHis');
        $rootElem->appendChild($xmlAttr);

        $this->appendXmlSignature($rootElem);
        $this->appendXmlService($rootElem);

        return $rootElem;
    }

    /**
     * @param \DOMElement $rootElem
     */
    protected function appendXmlSignature($rootElem)
    {
        $xmlElem = $this->xmlDoc->createElement('signature');
        $xmlElem->nodeValue = $this->signature;
        $rootElem->appendChild($xmlElem);
    }

    /**
     * @param \DOMElement $rootElem
     */
    protected function appendXmlService($rootElem)
    {
        $xmlElem = $this->xmlDoc->createElement('service');
        $xmlElem->nodeValue = $this->service;
        $rootElem->appendChild($xmlElem);
    }

    /**
     * @param \DOMElement $rootElem
     */
    protected function appendXmlSecretCode($rootElem)
    {
        if ($this->secretCode) {
            $xmlAttr = $this->xmlDoc->createAttribute('secretcode');
            $xmlAttr->nodeValue = $this->secretCode;
            $rootElem->appendChild($xmlAttr);
        }
    }

    /**
     * @param \DOMElement $rootElem
     */
    protected function appendXmlParams($rootElem)
    {
        if (is_array($this->params) && sizeof($this->params) > 0) {
            $xmlParams = $this->xmlDoc->createElement('params');
            foreach ($this->params as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        $this->appendXmlParam($rootElem, $xmlParams, $key, $v);
                    }
                } else {
                    $this->appendXmlParam($rootElem, $xmlParams, $key, $value);
                }
            }
            $rootElem->appendChild($xmlParams);
        }
    }

    /**
     * @param \DOMElement $rootElem
     * @param string $key
     * @param string $value
     */
    protected function appendXmlParam($rootElem, $xmlParams, $key, $value)
    {
        $xmlParam = $this->xmlDoc->createElement('param');
        $xmlName = $this->xmlDoc->createElement('name');
        $xmlName->nodeValue = trim($key);
        $xmlParam->appendChild($xmlName);
        $xmlValue = $this->xmlDoc->createElement('value');
        $xmlValue->appendChild($this->xmlDoc->createCDATASection($value));
        $xmlParam->appendChild($xmlValue);
        $xmlParams->appendChild($xmlParam);
    }

    /**
     * @param \DOMElement $rootElem
     */
    protected function appendReturnUrl($rootElem)
    {
        if (!is_null($this->returnUrl) || !is_null($this->confirmUrl)) {
            $xmlUrl = $this->xmlDoc->createElement('url');
            if (!is_null($this->returnUrl)) {
                $xmlElem = $this->xmlDoc->createElement('return');
                $xmlElem->nodeValue = $this->returnUrl;
                $xmlUrl->appendChild($xmlElem);
            }
            if (!is_null($this->confirmUrl)) {
                $xmlElem = $this->xmlDoc->createElement('confirm');
                $xmlElem->nodeValue = $this->confirmUrl;
                $xmlUrl->appendChild($xmlElem);
            }

            $rootElem->appendChild($xmlUrl);
        }
    }
}
