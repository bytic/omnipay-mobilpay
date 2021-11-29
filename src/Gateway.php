<?php

namespace Paytic\Omnipay\Mobilpay;

use Paytic\Omnipay\Common\Gateway\Traits\HasLanguageTrait;
use Paytic\Omnipay\Mobilpay\Gateway\HasParameters;
use Paytic\Omnipay\Mobilpay\Gateway\HasRequests;
use Paytic\Omnipay\Mobilpay\Utils\Settings;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;

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
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface fetchTransaction(array $options = [])
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
