<?php

namespace Paytic\Omnipay\Mobilpay\Models\Soap;

/**
 * Class User
 * @package Paytic\Omnipay\Mobilpay\Models\Soap
 */
class User extends AbstractModel
{
    /**
     * @var string
     */
    protected $username;

    /**password
     * @var string
     */
    protected $password;

    /**
     * @var Person
     */
    protected $person;

    /**
     * @var int
     */
    protected $id;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->person = new Person();
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson(Person $person)
    {
        $this->person = $person;
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
}
