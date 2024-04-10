<?php

namespace Paytic\Omnipay\Mobilpay;

use Omnipay\Common\Message\RequestInterface;
use Paytic\Omnipay\Common\Gateway\AbstractGateway;
use Paytic\Omnipay\Common\Gateway\Traits\HasLanguageTrait;
use Paytic\Omnipay\Mobilpay\Gateway\HasParameters;
use Paytic\Omnipay\Mobilpay\Gateway\HasRequests;

/**
 * Class Gateway
 * @package ByTIC\Mobilpay\Twispay
 *
 * @method RequestInterface authorize(array $options = [])
 * @method RequestInterface completeAuthorize(array $options = [])
 * @method RequestInterface capture(array $options = [])
 * @method RequestInterface refund(array $options = [])
 * @method RequestInterface void(array $options = [])
 * @method RequestInterface createCard(array $options = [])
 * @method RequestInterface updateCard(array $options = [])
 * @method RequestInterface deleteCard(array $options = [])
 * @method RequestInterface fetchTransaction(array $options = [])
 */
class Gateway extends AbstractGateway
{
    use HasRequests;
    use HasParameters;
    use HasLanguageTrait;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Mobilpay';
    }
}
