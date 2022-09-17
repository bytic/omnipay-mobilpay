<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Tests\Message\Soap\Payment;

use Omnipay\Common\Message\ResponseInterface;
use Paytic\Omnipay\Mobilpay\Message\AbstractRequest;
use Paytic\Omnipay\Mobilpay\Message\AbstractResponse;
use Paytic\Omnipay\Mobilpay\Message\Soap\Payment\DoPayTRequest;
use Paytic\Omnipay\Mobilpay\Message\Soap\Payment\DoPayTResponse;
use Paytic\Omnipay\Mobilpay\Tests\Message\AbstractResponseTest;
use stdClass;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 *
 */
class DoPayTResponseTest extends AbstractResponseTest
{
    public function test_isSuccessful_false_for_code()
    {
        $response = $this->newResponseWithData(DoPayTRequest::class, DoPayTResponse::class, ['code' => "8192"]);

        self::assertFalse($response->isSuccessful());
        self::assertFalse($response->isCancelled());
        self::assertFalse($response->isPending());
        self::assertFalse($response->isRedirect());
        self::assertFalse($response->isTransparentRedirect());
    }

    /**
     * @param string $class Request Class
     * @param array $data
     * @return AbstractResponse|ResponseInterface
     */
    protected function newResponseWithData($requestClass, $responseClass, $data = [])
    {
        $client = $this->getHttpClient();
        $request = HttpRequest::createFromGlobals();
        /** @var AbstractRequest $request */
        $request = new $requestClass($client, $request);

        return new $responseClass($request, $data);
    }

    public function test_error_response()
    {
        $data = new stdClass();
        $data->doPayTResult = require TEST_FIXTURE_PATH.'/requests/Soap/DoPayT/errorResponse.php';
        $response = $this->newResponseWithData(DoPayTRequest::class, DoPayTResponse::class, $data);

        self::assertFalse($response->isSuccessful());
        self::assertFalse($response->isCancelled());
        self::assertFalse($response->isPending());
        self::assertFalse($response->isRedirect());
        self::assertFalse($response->isTransparentRedirect());

        self::assertSame('48', $response->getCode());
        self::assertSame(
            'gwInvalidRequest: Array
(
    [item] => Array
        (
            [message] => Camp obligatoriu
            [code] => billing/phone
        )

)
',
            $response->getMessage()
        );
    }

    public function test_confirm_response()
    {
        $data = new stdClass();
        $data->doPayTResult = require TEST_FIXTURE_PATH.'/requests/Soap/DoPayT/confirmedResponse.php';
        $response = $this->newResponseWithData(DoPayTRequest::class, DoPayTResponse::class, $data);

        self::assertFalse($response->isCancelled());
        self::assertFalse($response->isPending());
        self::assertFalse($response->isRedirect());
        self::assertFalse($response->isTransparentRedirect());

        self::assertTrue($response->isSuccessful());

        self::assertSame('0', $response->getCode());
        self::assertSame(
            'gwApproved',
            $response->getMessage()
        );
    }
}
