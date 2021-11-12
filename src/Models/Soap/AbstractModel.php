<?php

namespace Paytic\Omnipay\Mobilpay\Models\Soap;

use Omnipay\Common\Helper;
use stdClass;

/**
 * Class AbstractModel
 * @package Paytic\Omnipay\Mobilpay\Models\Soap
 */
abstract class AbstractModel
{

    /**
     * @var []
     */
    protected $errors = [];

    /**
     * @param $params
     * @return static
     */
    public static function fromArray($params)
    {
        $model = new static();
        $model->initFromArray($params);

        return $model;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $properties = get_object_vars($this);
        $ignored = $this->toArrayIgnoredFields();
        foreach ($ignored as $ignore) {
            unset($properties[$ignore]);
        }
        $return = [];
        foreach ($properties as $name => $value) {
            $return[$name] = is_object($this->{$name}) ? $this->{$name}->toArray() : $value;
        }

        return $return;
    }

    /**
     * @return stdClass
     */
    public function toSoap()
    {
        $properties = get_object_vars($this);
        $ignored = $this->toArrayIgnoredFields();
        foreach ($ignored as $ignore) {
            unset($properties[$ignore]);
        }
        $return = new stdClass();
        foreach ($properties as $name => $value) {
            $return->{$name} = is_object($this->{$name}) ? $this->{$name}->toSoap() : $value;
        }

        return $return;
    }

    /**
     * @return array
     */
    protected function toArrayIgnoredFields()
    {
        return ['errors'];
    }

    /**
     * @param $params
     */
    protected function initFromArray($params)
    {
        foreach ($params as $name => $value) {
            $methodName = 'set'.ucfirst(Helper::camelCase($name));
            if (is_object($this->{$name})) {
                $this->{$name}->initFromArray($value);
            } elseif (method_exists($this, $methodName)) {
                $this->$methodName($value);
            } else {
                $this->{$name} = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }
}
