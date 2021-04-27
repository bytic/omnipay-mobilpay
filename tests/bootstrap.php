<?php

define('PROJECT_BASE_PATH', __DIR__.'/..');
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__.DIRECTORY_SEPARATOR.'fixtures');

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'.env')) {
    $enviroment = new Dotenv\Dotenv(__DIR__);
    $enviroment->load();
}

foreach (['MOBILPAY_PUBLIC_CER', 'MOBILPAY_PRIVATE_KEY','MOBILPAY_PRIVATE_KEY_SANDBOX'] as $key) {
    $value = getenv($key);
    if ($value) {
        putenv($key.'='.gzinflate(base64_decode($value)));
    }
}