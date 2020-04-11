<?php

namespace ByTIC\Omnipay\Mobilpay\Tests;

use ByTIC\Omnipay\Mobilpay\Tests\Traits\HasTestUtilMethods;
use PHPUnit\Framework\TestCase;

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
