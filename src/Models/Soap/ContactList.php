<?php

namespace ByTIC\Omnipay\Mobilpay\Models\Soap;

/**
 * Class ContactList
 * @package ByTIC\Omnipay\Mobilpay\Models\Soap
 */
class ContactList extends AbstractModel
{
    /**
     * @var Contact[]
     */
    protected $contacts;

    /**
     * @param Contact $contact
     */
    public function add(Contact $contact)
    {
        $this->contacts[] = $contact;
    }

    /**
     * @return Contact[]
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }

    /**
     * @param Contact[] $contacts
     */
    public function setContacts(array $contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $return = [];
        foreach ($this->contacts as $contact) {
            $return[] = $contact->toArray();
        }
        return $return;
    }

    /**
     * @inheritDoc
     */
    protected function initFromArray($params)
    {
        $keys = array_keys($params);
        if (is_string($keys[0])) {
            $params = [$params];
        }
        foreach ($params as $param) {
            $this->add(Contact::fromArray($param));
        }
    }
}
