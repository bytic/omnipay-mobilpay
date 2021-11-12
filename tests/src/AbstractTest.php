<?php

namespace Paytic\Omnipay\Mobilpay\Tests;

use Paytic\Omnipay\Mobilpay\Tests\Traits\HasTestUtilMethods;
use Omnipay\Tests\TestCase;

/**
 * Class AbstractTest
 */
abstract class AbstractTest extends TestCase
{
    use HasTestUtilMethods;

    protected $object;

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }
}
