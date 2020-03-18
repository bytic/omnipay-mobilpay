<?php /** @noinspection PhpUndefinedClassInspection */

namespace ByTIC\Omnipay\Mobilpay\Message\Soap;

/**
 * Class RegisterCompanyRequest
 * @package ByTIC\Omnipay\Mobilpay\Message\Soap
 */
class RegisterCompanyRequest extends AbstractSoapRequest
{

    /**
     * @inheritDoc
     */
    public function getData()
    {
        // TODO: Implement getData() method.
    }

    /**
     * Run the SOAP transaction
     *
     * @param SoapClient $soapClient
     * @param array $data
     * @return array
     * @throws \Exception
     */
    protected function runTransaction($soapClient, $data)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $soapClient->registerCompany($data);
    }
}
