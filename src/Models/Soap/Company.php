<?php

namespace ByTIC\Omnipay\Mobilpay\Models\Soap;

use ByTIC\Omnipay\Mobilpay\Models\Soap\Traits\HasPaymentMethods;
use ByTIC\Omnipay\Mobilpay\Utils\Constants;

/**
 * Class Company
 * @package ByTIC\Omnipay\Mobilpay\Models\Soap
 */
class Company extends AbstractModel
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

    protected $type = Constants::TYPE_COMPANY;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $reg_code;

    /**
     * @var bool
     */
    protected $vat = false;

    /**
     * @var Address
     */
    protected $address;

    /**
     * @var Bank
     */
    protected $bank;

    /**
     * @var string
     */
    protected $fax;

    /**
     * @var SellerAccountList
     */
    protected $seller_accounts;

    /**
     * Company constructor.
     */
    public function __construct()
    {
        $this->setAddress(new Address());
        $this->setBank(new Bank());
        $this->setSellerAccounts(new SellerAccountList());
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
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type)
    {
        $this->type = $type;
    }

    public function setTypeCompany()
    {
        $this->setType(self::TYPE_COMPANY);
    }

    public function setTypeFreelancer()
    {
        $this->setType(self::TYPE_FREELANCER);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getRegCode(): string
    {
        return $this->reg_code;
    }

    /**
     * @param string $reg_code
     */
    public function setRegCode(string $reg_code)
    {
        $reg_code = strtoupper(str_replace(' ', '', $reg_code));

        if (!preg_match('~^J[0-9]{2}/[0-9]{2,6}/(19|20)[0-9]{2}$~', $reg_code)) {
            throw new \Exception("'{$reg_code}' nu respecta tiparul 'JNN/NNNN/NNNN'");
        }
        $this->reg_code = $reg_code;
    }

    /**
     * @return bool
     */
    public function isVat(): bool
    {
        return $this->vat;
    }

    /**
     * @param bool $vat
     */
    public function setVat(bool $vat)
    {
        $this->vat = $vat;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return Bank
     */
    public function getBank(): Bank
    {
        return $this->bank;
    }

    /**
     * @param Bank $bank
     */
    public function setBank(Bank $bank)
    {
        $this->bank = $bank;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getFax(): string
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     */
    public function setFax(string $fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getSellerAccounts()
    {
        return $this->seller_accounts;
    }

    /**
     * @param mixed $seller_accounts
     */
    public function setSellerAccounts($seller_accounts)
    {
        $this->seller_accounts = $seller_accounts;
    }
}
