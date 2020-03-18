<?php

namespace ByTIC\Omnipay\Mobilpay\Gateway;

use ByTIC\Omnipay\Mobilpay\Utils\Settings;
use Omnipay\Common\AbstractGateway;

/**
 * Trait HasParameters
 * @package ByTIC\Omnipay\Mobilpay\Gateway
 */
trait HasParameters
{
    /**
     * @var string
     */
    protected $endpointSandbox = Settings::ENDPOINT_SANDBOX;

    /**
     * @var string
     */
    protected $endpointLive = Settings::ENDPOINT_LIVE;

    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string|null Certificate Content
     */
    protected $certificate;

    /**
     * @var string|null PrivateKey Content
     */
    protected $privateKey;


    /** @noinspection PhpMissingParentCallCommonInspection
     *
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return [
            'testMode' => $this->getTestMode(), // Must be the 1st in the list!
            'signature' => $this->getSignature(),
            'certificate' => $this->getCertificate(),
            'privateKey' => $this->getPrivateKey(),
            'card' => [
                'first_name' => '',
            ], //Add in order to generate the Card Object
        ];
    }


    /**
     * Get live- or testURL.
     */
    public function getEndpointUrl()
    {
        $defaultUrl = $this->getTestMode() === false
            ? $this->endpointLive
            : $this->endpointSandbox;

        return $this->parameters->get('endpointUrl', $defaultUrl);
    }

    /**
     * @param boolean $value
     * @return $this|AbstractGateway
     */
    public function setTestMode($value)
    {
        $this->parameters->remove('endpointUrl');

        return parent::setTestMode($value);
    }

    // ------------ Getter'n'Setters ------------ //

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    /**
     * @return null|string
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * @param null|string $certificate
     */
    public function setCertificate($certificate)
    {
        if (file_exists($certificate)) {
            $certificate = file_get_contents($certificate);
        }
        $this->certificate = $certificate;
    }

    /**
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @param string $privateKey
     */
    public function setPrivateKey(string $privateKey)
    {
        if (file_exists($privateKey)) {
            $privateKey = file_get_contents($privateKey);
        }
        $this->privateKey = $privateKey;
    }
}
