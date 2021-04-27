<?php

namespace ByTIC\Omnipay\Mobilpay\Gateway;

use ByTIC\Omnipay\Mobilpay\Utils\Settings;
use ByTIC\Omnipay\Mobilpay\Utils\Traits\HasAuthTrait;
use ByTIC\Omnipay\Mobilpay\Utils\Traits\HasSecurityParams;
use Omnipay\Common\AbstractGateway;

/**
 * Trait HasParameters
 * @package ByTIC\Omnipay\Mobilpay\Gateway
 */
trait HasParameters
{
    use HasSecurityParams;
    use HasAuthTrait;

    /**
     * @var string
     */
    protected $endpointSandbox = Settings::ENDPOINT_SANDBOX;

    /**
     * @var string
     */
    protected $endpointLive = Settings::ENDPOINT_LIVE;


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
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
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

}
