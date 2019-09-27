<?php

namespace Leankoala\UrlExtractor;

use GuzzleHttp\Psr7\Uri;
use Leankoala\UrlExtractor\Adapter\Adapter;
use Psr\Http\Message\UriInterface;

class Extractor
{
    /**
     * @param Adapter $adapter
     * @return UriInterface[]
     */
    public function extract(Adapter $adapter)
    {
        $urlStrings = $adapter->extract();

        $uris = [];

        foreach ($urlStrings as $urlString) {
            $uris[] = new Uri($urlString);
        }

        return $uris;
    }
}
