<?php

namespace Leankoala\UrlExtractor;

use GuzzleHttp\Psr7\Uri;
use Leankoala\UrlExtractor\Adapter\Adapter;
use Psr\Http\Message\UriInterface;

class Extractor
{
    /**
     * Extract all links from the given document represented by an adapter
     *
     * @param Adapter $adapter
     * @return UriInterface[]
     */
    public function extract(Adapter $adapter)
    {
        $urlStrings = $adapter->extract();

        $uris = [];

        foreach ($urlStrings as $urlString) {
            if ($urlString instanceof UriInterface) {
                $uris[] = $urlString;
            } else {
                $uris[] = new Uri($urlString);
            }
        }

        $uris = array_unique($uris);

        return $uris;
    }
}
