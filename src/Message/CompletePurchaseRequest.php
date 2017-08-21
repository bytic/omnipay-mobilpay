<?php

namespace ByTIC\Omnipay\Mobilpay\Message;

/**
 * Class PurchaseResponse
 * @package ByTIC\Common\Payments\Gateways\Providers\AbstractGateway\Messages
 */
class CompletePurchaseRequest extends AbstractRequest
{

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $data = [];
        $data['orderId'] = $this->httpRequest->query->get('orderId');

        return $data;
    }
}
