<?php

namespace Paytic\Omnipay\Mobilpay\Models\Soap;

/**
 * Class Person
 * @package Paytic\Omnipay\Mobilpay\Models\Soap
 */
class Person extends AbstractModel
{

    /**
     * @var string
     */
    protected $first_name;

    /**
     * @var string
     */
    protected $last_name;

    /**
     * @var ContactList
     */
    protected $contacts;

    protected $type = self::TYPE_COMMERCIAL;

    const TYPE_COMMERCIAL = 1;
    const TYPE_TEHNICAL = 2;

    /**
     * Person constructor.
     */
    public function __construct()
    {
        $this->contacts = new ContactList();
    }


    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @param Contact $contact
     */
    public function addContact(Contact $contact)
    {
        $this->contacts->add($contact);
    }

    /**
     * @return ContactList
     */
    public function getContacts(): ContactList
    {
        return $this->contacts;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function setTypeCommercial()
    {
        $this->setType(self::TYPE_COMMERCIAL);
    }

    /**
     * @return bool
     */
    public function isTypeCommercial()
    {
        return $this->type == self::TYPE_COMMERCIAL;
    }

    public function setTypeTehnical()
    {
        $this->setType(self::TYPE_TEHNICAL);
    }

    /**
     * @return int
     */
    public function isTypeTehnical()
    {
        return $this->type = self::TYPE_TEHNICAL;
    }
}
