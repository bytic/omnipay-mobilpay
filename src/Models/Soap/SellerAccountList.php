<?php

namespace ByTIC\Omnipay\Mobilpay\Models\Soap;

/**
 * Class SellerAccountList
 * @package ByTIC\Omnipay\Mobilpay\Models\Soap
 */
class SellerAccountList extends AbstractListModel
{

    /**
     * @inheritDoc
     */
    protected static function itemClass()
    {
        return SellerAccount::class;
    }
}
