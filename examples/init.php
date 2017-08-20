<?php

require dirname(__DIR__).'/vendor/autoload.php';

$testsDirectory = dirname(__DIR__).DIRECTORY_SEPARATOR.'tests';
if (file_exists($testsDirectory.DIRECTORY_SEPARATOR.'.env')) {
    $env = new Dotenv\Dotenv($testsDirectory);
    $env->load();
    $_ENV['MOBILPAY_CERTIFICATE'] = base64_decode($_ENV['MOBILPAY_CERTIFICATE']);
}
