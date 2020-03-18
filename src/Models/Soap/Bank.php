<?php

namespace ByTIC\Omnipay\Mobilpay\Models\Soap;

/**
 * Class Bank
 * @package ByTIC\Omnipay\Mobilpay\Models\Soap
 */
class Bank extends AbstractModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $branch;

    /**
     * @var string
     */
    protected $iban;

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
    public function getBranch(): string
    {
        return $this->branch;
    }

    /**
     * @param string $branch
     */
    public function setBranch(string $branch)
    {
        $this->branch = $branch;
    }

    /**
     * @return string
     */
    public function getIban(): string
    {
        return $this->iban;
    }

    /**
     * @param string $iban
     * @throws \Exception
     */
    public function setIban(string $iban)
    {
        $iban = strtoupper(str_replace(' ', '', $iban));

        if (!preg_match('/^[a-zA-Z]{2}[0-9]{2}[a-zA-Z0-9]{4}[0-9]{7}([a-zA-Z0-9]?){0,16}$/', $iban)) {
            throw new \Exception("'{$iban}' nu respecta formatul IBAN");
        }
        $this->iban = $iban;
    }
}
