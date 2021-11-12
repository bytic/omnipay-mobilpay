<?php

namespace Paytic\Omnipay\Mobilpay\Models\Soap;

/**
 * Class Address
 * @package Paytic\Omnipay\Mobilpay\Models\Soap
 */
class Address extends AbstractModel
{
    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $county;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    protected $postal_code;

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCounty(): string
    {
        return $this->county;
    }

    /**
     * @param string $county
     */
    public function setCounty(string $county)
    {
        $this->county = $county;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postal_code;
    }

    /**
     * @param string $postal_code
     */
    public function setPostalCode(string $postal_code)
    {
        $this->postal_code = $postal_code;
    }
}
