<?php

namespace ByTIC\Omnipay\Mobilpay\Message\Soap\Merchant;

use ByTIC\Omnipay\Mobilpay\Message\Soap\AbstractSoapRequest;
use ByTIC\Omnipay\Mobilpay\Message\Soap\Traits\HasSessionId;
use Exception;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use SoapClient;
use SoapFault;

/**
 * Class RegisterCompanyRequest
 * @package ByTIC\Omnipay\Mobilpay\Message\Soap
 */
class RegisterCompanyRequest extends AbstractSoapRequest
{
    use HasSessionId;

    /**
     * @inheritDoc
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('sessionId', 'user', 'company', 'tehnical_person');

        return [
            'sessionId' => $this->getSessionId(),
            'user' => $this->getUser(),
            'company' => $this->getCompany(),
            'tehnical_person' => $this->getTehnicalPerson(),
        ];
    }

    /**
     * Run the SOAP transaction
     *
     * @param SoapClient $soapClient
     * @param array $data
     * @return array
     * @throws Exception
     */
    protected function runTransaction($soapClient, $data)
    {
        return $this->runSoapTransaction($soapClient, 'registerCompany', $data);
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->getParameter('user');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setUser($value)
    {
        return $this->setParameter('user', $value);
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->getParameter('company');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setCompany($value)
    {
        return $this->setParameter('company', $value);
    }

    /**
     * @return mixed
     */
    public function getTehnicalPerson()
    {
        return $this->getParameter('tehnical_person');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setTehnicalPerson($value)
    {
        return $this->setParameter('tehnical_person', $value);
    }
}
