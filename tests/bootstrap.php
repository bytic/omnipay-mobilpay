<?php

define('PROJECT_BASE_PATH', __DIR__.'/..');
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__.DIRECTORY_SEPARATOR.'fixtures');

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'.env')) {
    $enviroment = new Dotenv\Dotenv(__DIR__);
    $enviroment->load();

    putenv('MOBILPAY_PUBLIC_CER='.gzinflate(base64_decode(getenv('MOBILPAY_PUBLIC_CER'))));
    putenv('MOBILPAY_PRIVATE_KEY='.gzinflate(base64_decode(getenv('MOBILPAY_PRIVATE_KEY'))));
}
