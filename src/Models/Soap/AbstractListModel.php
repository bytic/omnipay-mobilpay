<?php

namespace ByTIC\Omnipay\Mobilpay\Models\Soap;

/**
 * Class SellerAccountList
 * @package ByTIC\Omnipay\Mobilpay\Models\Soap
 */
abstract class AbstractListModel extends AbstractModel
{
    /**
     * @var AbstractModel[]
     */
    protected $items;

    /**
     * @param AbstractModel $contact
     */
    public function add(AbstractModel $contact)
    {
        $this->items[] = $contact;
    }

    /**
     * @return AbstractModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param AbstractModel[] $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $return = [];
        foreach ($this->items as $contact) {
            $return[] = $contact->toArray();
        }

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function toSoap()
    {
        $return = [];
        foreach ($this->items as $contact) {
            $return[] = $contact->toSoap();
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
            $itemClass = static::itemClass();
            $item = call_user_func([$itemClass, 'fromArray'], $param);
            $this->add($item);
        }
    }

    /**
     * @return string
     */
    abstract protected static function itemClass();
}
