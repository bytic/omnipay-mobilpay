<?php /** @noinspection PhpComposerExtensionStubsInspection */

namespace ByTIC\Omnipay\Mobilpay\Tests\Message\Soap;

use ByTIC\Omnipay\Mobilpay\Message\Soap\Merchant\LogInRequest;
use ByTIC\Omnipay\Mobilpay\Message\Soap\SoapResponse;
use ByTIC\Omnipay\Mobilpay\Tests\AbstractTest;
use SoapClient;

/**
 * Class LogInRequestTest
 * @package ByTIC\Omnipay\Mobilpay\Tests\Message\Soap
 */
class LogInRequestTest extends AbstractTest
{
    /** @var  LogInRequest */
    protected $request;

    public function test_send()
    {
        $params = [
            'username' => 'test',
            'password' => 'testpassword',
        ];
        $mock = $this->applySoapClientMock();
        $mock->shouldReceive('__soapCall')->once()->with('logIn', $params);

        $this->request->initialize($params);
        $response = $this->request->send($params);

        self::assertInstanceOf(SoapResponse::class, $response);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new LogInRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    /**
     * @return \Mockery\Mock
     */
    protected function applySoapClientMock()
    {
        $mock = \Mockery::mock(SoapClient::class)->makePartial();
        $this->request->setSoapClient($mock);

        return $mock;
    }
}
