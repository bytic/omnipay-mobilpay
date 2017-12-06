<?php

namespace ByTIC\Omnipay\Mobilpay\Message;

use ByTIC\Omnipay\Common\Library\Signer;
use ByTIC\Omnipay\Common\Message\Traits\RequestDataGetWithValidationTrait;
use ByTIC\Omnipay\Mobilpay\Models\Address;
use ByTIC\Omnipay\Mobilpay\Models\Invoice;
use ByTIC\Omnipay\Mobilpay\Models\Request\Card;

/**
 * Class PurchaseRequest
 * @package ByTIC\Omnipay\Mobilpay\Message
 *
 * @method PurchaseResponse send()
 */
class PurchaseRequest extends AbstractRequest
{
    use RequestDataGetWithValidationTrait;

    /**
     * @var Card
     */
    protected $cardRequest = null;


    /**
     * @inheritdoc
     */
    public function initialize(array $parameters = [])
    {
        $parameters['currency'] = isset($parameters['currency']) ? $parameters['currency'] : 'ron';

        return parent::initialize($parameters);
    }


    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritdoc
     */
    public function validateDataFields()
    {
        return [
            'signature',
            'certificate',
//            'privateKey',
            'amount',
            'orderId',
//            'orderId', 'orderName', 'orderDate',
//            'notifyUrl', 'returnUrl', 'signature', 'certificate',
//            'card'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function populateData()
    {
        $data = [];
        $this->populateMobilpayCardRequest();
        $cardRequest = $this->getMobilpayCardRequest();

        $signer = new Signer();
        $signer->setCertificate($this->getCertificate());
//        echo $cardRequest->getXML();die();
        $sealedContent = $signer->sealContentWithRSA($cardRequest->getXML());
        $data['env_key'] = base64_encode($sealedContent[1][0]);
        $data['data'] = base64_encode($sealedContent[0]);
        $data['redirectUrl'] = $this->getEndpointUrl();

        return $data;
    }

    protected function populateMobilpayCardRequest()
    {
        $card = $this->getMobilpayCardRequest();
        $card->orderId = $this->getOrderId();
        $card->returnUrl = ''.$this->getReturnUrl(); //Add spaces to add the item to the XML
        $card->confirmUrl = ''.$this->getNotifyUrl(); //Add spaces to add the item to the XML
        $card->invoice = $this->generateMobilpayPaymentInvoice();

//        $card->encrypt($this->getCertificate());
    }

    /**
     * @return Card
     */
    protected function getMobilpayCardRequest()
    {
        if ($this->cardRequest == null) {
            $this->cardRequest = new Card();
            $this->cardRequest->signature = $this->getSignature();
        }

        return $this->cardRequest;
    }

    /**
     * @return Invoice
     */
    protected function generateMobilpayPaymentInvoice()
    {
        $invoice = new Invoice();
        $invoice->currency = $this->getCurrency();
        $invoice->amount = $this->getAmount();
        $invoice->installments = '2,3';
        $invoice->details = $this->getDescription();
        $invoice->setBillingAddress($this->generateMobilpayPaymentBillingAddress());
        $invoice->setShippingAddress($this->generateMobilpayPaymentShippingAddress());

        return $invoice;
    }

    /**
     * @return Address
     */
    protected function generateMobilpayPaymentBillingAddress()
    {
        $card = $this->getCard();
        $address = new Address();
        $address->type = 'person'; //company
        $address->firstName = $card->getBillingFirstName();
        $address->lastName = $card->getBillingLastName();
        $address->fiscalNumber = '';
        $address->identityNumber = '';
        $address->country = $card->getBillingCountry();
        $address->county = '';
        $address->city = $card->getBillingCity();
        $address->zipCode = '';
        $address->address = $card->getBillingAddress1().' '.$card->getBillingAddress2();
        $address->email = $card->getEmail();
        $address->mobilePhone = $card->getBillingPhone();
        $address->bank = '';
        $address->iban = '';

        return $address;
    }

    /**
     * @return Address
     */
    protected function generateMobilpayPaymentShippingAddress()
    {
        $card = $this->getCard();
        $address = new Address();
        $address->type = 'person'; //company
        $address->firstName = $card->getShippingFirstName();
        $address->lastName = $card->getShippingLastName();
        $address->fiscalNumber = '';
        $address->identityNumber = '';
        $address->country = $card->getShippingCountry();
        $address->county = '';
        $address->city = $card->getShippingCity();
        $address->zipCode = '';
        $address->address = $card->getShippingAddress1().' '.$card->getShippingAddress2();
        $address->email = $card->getEmail();
        $address->mobilePhone = $card->getShippingPhone();
        $address->bank = '';
        $address->iban = '';

        return $address;
    }
}
