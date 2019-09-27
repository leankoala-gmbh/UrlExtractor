<?php

namespace Leankoala\UrlExtractor\Adapter;

use Psr\Http\Message\UriInterface;
use whm\Html\Document;

class HtmlAnchorAdapter implements Adapter
{
    private $content;
    private $baseUri;

    public function __construct(UriInterface $baseUri, $content)
    {
        $this->content = $content;
        $this->baseUri = $baseUri;
    }

    public function extract()
    {
        $htmlDocument = new Document($this->content);
        $links = $htmlDocument->getOutgoingLinks($this->baseUri);
        return $links;
    }
}
