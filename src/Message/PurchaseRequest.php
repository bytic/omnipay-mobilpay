<?php

namespace Paytic\Omnipay\Mobilpay\Message;

use Paytic\Omnipay\Common\Library\Signer;
use Paytic\Omnipay\Common\Message\Traits\HasLanguageRequestTrait;
use Paytic\Omnipay\Common\Message\Traits\RequestDataGetWithValidationTrait;
use Paytic\Omnipay\Mobilpay\Models\Address;
use Paytic\Omnipay\Mobilpay\Models\Invoice;
use Paytic\Omnipay\Mobilpay\Models\PaymentRecurrence;
use Paytic\Omnipay\Mobilpay\Models\PaymentSplit;
use Paytic\Omnipay\Mobilpay\Models\Request\Card;

/**
 * Class PurchaseRequest
 * @package Paytic\Omnipay\Mobilpay\Message
 *
 * @method PurchaseResponse send()
 */
class PurchaseRequest extends AbstractRequest
{
    use RequestDataGetWithValidationTrait;
    use HasLanguageRequestTrait;

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
        $cardRequest = $this->populateMobilpayCardRequest();

        $signer = new Signer();
        $signer->setCertificate($this->getCertificate());
//        echo $cardRequest->getXML();die();
        $sealedContent = $signer->sealContentWithRSA($cardRequest->getXML());
        $data['env_key'] = base64_encode($sealedContent[1][0]);
        $data['data'] = base64_encode($sealedContent[0]);
        $data['redirectUrl'] = $this->getEndpointUrl();
        $data['lang'] = $this->getLang();

        return $data;
    }

    /**
     * @return Card
     */
    public function populateMobilpayCardRequest()
    {
        $card = $this->getMobilpayCardRequest();
        $card->orderId = $this->getOrderId();
        $card->returnUrl = ''.$this->getReturnUrl(); //Add spaces to add the item to the XML
        $card->confirmUrl = ''.$this->getNotifyUrl(); //Add spaces to add the item to the XML
        $card->invoice = $this->generateMobilpayPaymentInvoice();

        $this->generateMobilpayPaymentRecurrence($card);
        $this->generateMobilpayPaymentSplit($card);

        return $card;
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
     * @noinspection PhpDocMissingThrowsInspection
     */
    protected function generateMobilpayPaymentInvoice()
    {
        $invoice = new Invoice();
        $invoice->currency = $this->getCurrency();
        /** @noinspection PhpUnhandledExceptionInspection */
        $invoice->amount = $this->getAmount();
        $invoice->installments = '2,3';
        $invoice->details = $this->getDescription();
        $invoice->setBillingAddress($this->generateMobilpayPaymentBillingAddress());
        $invoice->setShippingAddress($this->generateMobilpayPaymentShippingAddress());

        return $invoice;
    }

    /**
     * @param Card $card
     */
    protected function generateMobilpayPaymentRecurrence(Card $card)
    {
        $recurrence = $this->getParameter('recurrence');
        if (is_array($recurrence)) {
            $card->recurrence = new PaymentRecurrence();
            if (isset($recurrence['interval'])) {
                $card->recurrence->setIntervalDay($recurrence['interval']);
            }
            if (isset($recurrence['times'])) {
                $card->recurrence->setPaymentsNo($recurrence['times']);
            }
        }
    }

    /**
     * @param Card $card
     */
    protected function generateMobilpayPaymentSplit(Card $card)
    {
        $split = $this->getParameter('split');
        if (is_array($split)) {
            $card->split = new PaymentSplit();
            foreach ($split as $destination => $value) {
                $card->split->destinations[] = [
                    'id' => $destination,
                    'amount' => $value,
                ];
            }
        }
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

    /**
     * @return mixed
     */
    public function getSplit()
    {
        return $this->getParameter('split');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setSplit($value)
    {
        return $this->setParameter('split', $value);
    }
}
