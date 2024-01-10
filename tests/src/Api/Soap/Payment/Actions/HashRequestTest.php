<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Tests\Api\Soap\Payment\Actions;

use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Actions\HashRequest;
use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto\Account;
use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto\Order;
use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto\Request;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class HashRequestTest extends TestCase
{
    public function test_hash()
    {
        $request = new Request();

        $order = new Order();
        $order->id = '68ecadb2-537f-4b02-af8a-0ddcf3eb2a80';
        $order->amount = 200;
        $order->currency = 'RON';
        $request->order = $order;

        $account = new Account();
        $account->id = '2U9Q-NCPN-ESQ4-MEXJ-QMDR';
        $request->account = $account;

        $hash = HashRequest::fromRequest($request, 'test')->calculate();

        self::assertSame('354C1C52FFAA85BD41A0CA5287324BFEBF7C3002', $hash);
    }
}
