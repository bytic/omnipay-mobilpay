<?php

namespace Paytic\Omnipay\Mobilpay\Models\Soap;

/**
 * Class ContactList
 * @package Paytic\Omnipay\Mobilpay\Models\Soap
 */
class ContactList extends AbstractListModel
{
    /**
     * @inheritDoc
     */
    protected static function itemClass()
    {
        return Contact::class;
    }
}
