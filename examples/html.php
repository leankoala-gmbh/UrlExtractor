<?php

include_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Psr7\Uri;
use Leankoala\UrlExtractor\Adapter\HtmlAnchorAdapter;
use Leankoala\UrlExtractor\Extractor;

$extractor = new Extractor();
$uris = $extractor->extract(new HtmlAnchorAdapter(new Uri('https://www.leankoala.com'), file_get_contents(__DIR__ . '/html/simple.html')));

echo "\nFound " . count($uris) . " URLs in the given document.\n\n";

foreach ($uris as $uri) {
    echo " - " . (string)$uri . "\n";
}

echo "\n";