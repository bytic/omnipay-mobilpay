<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Message\Soap;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Paytic\Omnipay\Common\Message\Traits\DataAccessorsTrait;

/**
 * Class AbstractSoapResponse
 * @package Paytic\Omnipay\Mobilpay\Message\Soap
 */
abstract class AbstractSoapResponse extends AbstractResponse
{
    use DataAccessorsTrait;

    /**
     * Constructor
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        if (is_object($data)) {
            $data = json_decode(json_encode($data), true);
        }

        parent::__construct($request, $data);
    }

}
