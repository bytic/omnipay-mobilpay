<?php

namespace Paytic\Omnipay\Mobilpay\Models\Soap;

use Paytic\Omnipay\Mobilpay\Models\Soap\Traits\HasPaymentMethods;

/**
 * Class SellerAccount
 * @package Paytic\Omnipay\Mobilpay\Models\Soap
 */
class SellerAccount extends AbstractModel
{
    use HasPaymentMethods;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var boolean
     */
    protected $under_contruction = true;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $confirm_url = null;

    /**
     * @var string
     */
    protected $return_url = null;

    /**
     * @var string
     */
    protected $mobilpay_key = null;

    /**
     * @var string
     */
    protected $merchant_key = null;

    /**
     * @var string
     */
    protected $signature = null;

    /**
     * @return bool
     */
    public function isUnderContruction(): bool
    {
        return $this->under_contruction;
    }

    /**
     * @param bool $under_contruction
     */
    public function setUnderContruction(bool $under_contruction)
    {
        $this->under_contruction = $under_contruction;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getConfirmUrl(): string
    {
        return $this->confirm_url;
    }

    /**
     * @param string $confirm_url
     */
    public function setConfirmUrl(string $confirm_url)
    {
        $this->confirm_url = $confirm_url;
    }

    /**
     * @return string
     */
    public function getReturnUrl(): string
    {
        return $this->return_url;
    }

    /**
     * @param string $return_url
     */
    public function setReturnUrl(string $return_url)
    {
        $this->return_url = $return_url;
    }

    /**
     * @return string
     */
    public function getMobilpayKey(): string
    {
        return $this->mobilpay_key;
    }

    /**
     * @param string $mobilpay_key
     */
    public function setMobilpayKey(string $mobilpay_key)
    {
        $this->mobilpay_key = $mobilpay_key;
    }

    /**
     * @return string
     */
    public function getMerchantKey(): string
    {
        return $this->merchant_key;
    }

    /**
     * @param string $merchant_key
     */
    public function setMerchantKey(string $merchant_key)
    {
        $this->merchant_key = $merchant_key;
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * @param string $signature
     */
    public function setSignature(string $signature)
    {
        $this->signature = $signature;
    }
}
