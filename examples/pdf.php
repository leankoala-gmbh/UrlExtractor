<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Leankoala\UrlExtractor\Extractor;
use Leankoala\UrlExtractor\Adapter\PdfAdapter;

$extractor = new Extractor();
$uris = $extractor->extract(new PdfAdapter(file_get_contents(__DIR__ . '/pdf/leankoala_com.pdf')));

echo "\nFound " . count($uris) . " URLs in the given document.\n\n";

foreach ($uris as $uri) {
    echo " - " . (string)$uri . "\n";
}

echo "\n";