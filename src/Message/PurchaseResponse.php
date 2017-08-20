<?php

namespace ByTIC\Omnipay\Mobilpay\Message;

use ByTIC\Omnipay\Common\Message\Traits\RedirectHtmlTrait;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * PayU Purchase Response
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    use RedirectHtmlTrait;

    /**
     * @return array
     */
    public function getRedirectData()
    {
        $data = [
            'env_key' => $this->getDataProperty('env_key'),
            'data' => $this->getDataProperty('data'),
        ];

        return $data;
    }
}
