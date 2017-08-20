<?php

namespace ByTIC\Omnipay\Mobilpay\Message\Traits;

/**
 * Trait RequestGetDataTrait
 * @package ByTIC\Omnipay\Mobilpay\Message\Traits
 */
trait RequestGetDataTrait
{

    public function getData()
    {
        $this->validateData();

        return $this->populateData();
    }

    protected function validateData()
    {
        $fields = null;
        if (method_exists($this, 'validateDataFields')) {
            $fields = $this->validateDataFields();
        }

        if (is_array($fields) && count($fields)) {
            $this->validate(...$fields);
        }
    }

    /**
     * @return array
     */
    protected function populateData()
    {
        return [];
    }

    /**
     * @param array $field
     * @return mixed
     */
    abstract function validate();

}