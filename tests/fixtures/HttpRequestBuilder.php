<?php

namespace ByTIC\Omnipay\Mobilpay\Tests\Fixtures;

use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class HttpRequestBuilder
 * @package ByTIC\Omnipay\Mobilpay\Tests\Fixtures
 */
class HttpRequestBuilder
{
    /**
     * @return HttpRequest
     */
    public static function createCompletePurchase()
    {
        $request = self::create();
        $request->query->add(self::getFileContents('completePurchaseGet'));

        return $request;
    }

    /**
     * @return HttpRequest
     */
    public static function create()
    {
        $request = new HttpRequest();

        return $request;
    }

    /**
     * @param $file
     * @return string
     */
    public static function getFileContents($file)
    {
        $content = file_get_contents(TEST_FIXTURE_PATH.'/requests/'.$file.'.json');
        $content = json_decode($content, true);

        $content = array_map('urldecode', $content);

        return $content;
    }

    /**
     * @return HttpRequest
     */
    public static function createServerCompletePurchase()
    {
        $request = self::create();
        $request->request->add(self::getFileContents('serverCompletePurchasePost'));

        return $request;
    }
}
