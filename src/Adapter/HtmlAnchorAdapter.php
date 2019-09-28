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
        $this->content = (string)$content;
        $this->baseUri = $baseUri;
    }

    public function extract()
    {
        $contentWithoutScripts = Document::removeScriptTags($this->content);

        $htmlDocument = new Document($contentWithoutScripts);

        $links = $htmlDocument->getOutgoingLinks($this->baseUri);
        return $links;
    }
}
