<?php /** @noinspection PhpComposerExtensionStubsInspection */

namespace ByTIC\Omnipay\Mobilpay\Message\Soap;

use ByTIC\Omnipay\Mobilpay\Utils\Settings;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
use SoapClient;
use SoapFault;

/**
 * Class SoapAbstractRequest
 * @package ByTIC\Omnipay\Mobilpay\Message\Soap
 */
abstract class AbstractSoapRequest extends OmnipayAbstractRequest
{
    /** @var  SoapClient */
    protected $soapClient;

    /**
     * The amount of time in seconds to wait for both a connection and a response.
     *
     * Total potential wait time is this value times 2 (connection + response).
     *
     * @var float
     */
    public $timeout = 10;

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return Settings::SOAP_LIVE;
    }

    /**
     * @return SoapClient
     */
    public function getSoapClient(): SoapClient
    {
        return $this->soapClient;
    }

    /**
     * @param SoapClient $soapClient
     */
    public function setSoapClient(SoapClient $soapClient)
    {
        $this->soapClient = $soapClient;
    }

    /**
     * Build the SOAP Client and the internal request object
     *
     * @return SoapClient
     * @throws \Exception
     */
    public function buildSoapClient()
    {
        if (!empty($this->soapClient)) {
            return $this->soapClient;
        }

        $context_options = [
            'http' => [
                'timeout' => $this->timeout,
            ],
        ];

        $context = stream_context_create($context_options);

        // options we pass into the soap client
        // turn on HTTP compression
        // set the internal character encoding to avoid random conversions
        // throw SoapFault exceptions when there is an error
        $soap_options = [
            'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
            'encoding' => 'utf-8',
            'exceptions' => true,
            'connection_timeout' => $this->timeout,
            'stream_context' => $context,
        ];

        // if we're in test mode, don't cache the wsdl
        if ($this->getTestMode()) {
            $soap_options['cache_wsdl'] = WSDL_CACHE_NONE;
        } else {
            $soap_options['cache_wsdl'] = WSDL_CACHE_BOTH;
        }

        try {
            // create the soap client
            $this->soapClient = new \SoapClient($this->getEndpoint(), $soap_options);

            return $this->soapClient;
        } catch (SoapFault $sf) {
            throw new \Exception($sf->getMessage(), $sf->getCode());
        }
    }

    /**
     * Send Data to the Gateway
     *
     * @param array $data
     * @return SoapResponse
     * @throws \Exception
     */
    public function sendData($data)
    {
        // Build the SOAP client
        $soapClient = $this->buildSoapClient();

        // Replace this line with the correct function.
        $response = $this->runTransaction($soapClient, $data);

        $class = $this->getResponseClass();

        return $this->response = new $class($this, $response);
    }

    /**
     * Run the SOAP transaction
     *
     * Over-ride this in sub classes.
     *
     * @param SoapClient $soapClient
     * @param array $data
     * @return array
     * @throws \Exception
     */
    abstract protected function runTransaction($soapClient, $data);

    /**
     * @param SoapClient $soapClient
     * @param $method
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    protected function runSoapTransaction($soapClient, $method, $data = [])
    {
        try {
            return $soapClient->__soapCall($method, $data);
        } catch (SoapFault $soapFault) {
            return [
                "code" => $soapFault->faultcode,
                "message" => $soapFault->getMessage(),
            ];
        }
    }

    /**
     * @return string
     */
    protected function getResponseClass()
    {
        return SoapResponse::class;
    }

}
