<?php

namespace ByTIC\Omnipay\Mobilpay\Tests\Message;

use ByTIC\Omnipay\Mobilpay\Message\AbstractRequest;
use ByTIC\Omnipay\Mobilpay\Tests\Traits\HasTestUtilMethods;
use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class AbstractRequestTest
 * @package ByTIC\Omnipay\Mobilpay\Tests\Message
 */
abstract class AbstractRequestTest extends TestCase
{
    use HasTestUtilMethods;

    /**
     * @param string $class
     * @param array $data
     * @return AbstractRequest
     */
    protected function newRequestWithInitTest($class, $data)
    {
        $request = $this->newRequest($class);
        self::assertInstanceOf($class, $request);
        $request->initialize($data);
        return $request;
    }

    /**
     * @param string $class
     * @return AbstractRequest
     */
    protected function newRequest($class)
    {
        $client = $this->getHttpClient();
        $request = HttpRequest::createFromGlobals();
        $request = new $class($client, $request);
        return $request;
    }
}
