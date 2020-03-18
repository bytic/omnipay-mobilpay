<?php

namespace ByTIC\Omnipay\Mobilpay\Models\Soap;

/**
 * Class Contact
 * @package ByTIC\Omnipay\Mobilpay\Models\Soap
 */
class Contact extends AbstractModel
{
    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $email;

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @throws \Exception
     */
    public function setPhone(string $phone)
    {
        $phone = str_replace(' ', '', $phone);

        if (!preg_match('/^[0-9]{9,10}$/', $phone)) {
            throw new \Exception("Numarul de telefon verificat '{$phone}' nu are un format invalid!");
        }
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
}
