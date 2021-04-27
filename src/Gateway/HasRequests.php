<?php

namespace ByTIC\Omnipay\Mobilpay\Gateway;

use ByTIC\Omnipay\Mobilpay\Message\CompletePurchaseRequest;
use ByTIC\Omnipay\Mobilpay\Message\PurchaseRequest;
use ByTIC\Omnipay\Mobilpay\Message\ServerCompletePurchaseRequest;
use ByTIC\Omnipay\Mobilpay\Message\Soap\Merchant\LogInRequest;
use ByTIC\Omnipay\Mobilpay\Message\Soap\Merchant\RegisterCompanyRequest;
use ByTIC\Omnipay\Mobilpay\Message\Soap\Merchant\ValidateRequestRequest;
use ByTIC\Omnipay\Mobilpay\Message\Soap\Payment\CancelRecurrenceRequest;
use ByTIC\Omnipay\Mobilpay\Message\Soap\Payment\DoPayTRequest;
use Omnipay\Common\Message\RequestInterface;

/**
 * Trait HasRequests
 * @package ByTIC\Omnipay\Mobilpay\Gateway
 */
trait HasRequests
{
    /**
     * @inheritdoc
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = []): RequestInterface
    {
        $parameters['endpointUrl'] = $this->getEndpointUrl();
        $this->populateRequestLangParam($parameters);

        return $this->createRequest(
            PurchaseRequest::class,
            array_merge($this->getDefaultParameters(), $parameters)
        );
    }

    /**
     * @inheritdoc
     */
    public function completePurchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest(
            CompletePurchaseRequest::class,
            array_merge($this->getDefaultParameters(), $parameters)
        );
    }

    /**
     * @inheritdoc
     */
    public function serverCompletePurchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest(
            ServerCompletePurchaseRequest::class,
            array_merge($this->getDefaultParameters(), $parameters)
        );
    }

    /**
     * @inheritdoc
     */
    public function logIn(array $parameters = []): RequestInterface
    {
        return $this->createRequest(
            LogInRequest::class,
            array_merge($this->getDefaultParameters(), $parameters)
        );
    }

    /**
     * @inheritdoc
     */
    public function registerCompany(array $parameters = []): RequestInterface
    {
        return $this->createRequest(
            RegisterCompanyRequest::class,
            array_merge($this->getDefaultParameters(), $parameters)
        );
    }

    /**
     * @inheritdoc
     */
    public function doPayT(array $parameters = []): RequestInterface
    {
        return $this->createRequest(
            DoPayTRequest::class,
            array_merge($this->getDefaultParameters(), $parameters)
        );
    }

    /**
     * @inheritdoc
     */
    public function cancelRecurrence(array $parameters = []): RequestInterface
    {
        return $this->createRequest(
            CancelRecurrenceRequest::class,
            array_merge($this->getDefaultParameters(), $parameters)
        );
    }

    /**
     * @inheritdoc
     */
    public function validateRequest(array $parameters = []): RequestInterface
    {
        return $this->createRequest(
            ValidateRequestRequest::class,
            array_merge($this->getDefaultParameters(), $parameters)
        );
    }
}
