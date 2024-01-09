<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Tests\Api\Soap\Payment\Dto;

use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * @return void
     * @dataProvider data_amount_setting
     */
    public function test_amount_setting($amount, $expected)
    {
        $order = new Order();
        $order->setAmount($amount);
        self::assertSame($expected, "{$order->amount}");
    }

    public function data_amount_setting()
    {
        return [
            [15, "15"],
            [15.00, "15"],
            [15.30, "15.3"],
            ["15.30", "15.3"],
        ];
    }
}
