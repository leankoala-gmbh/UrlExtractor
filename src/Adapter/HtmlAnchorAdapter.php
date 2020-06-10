<?php

namespace Leankoala\UrlExtractor\Adapter;

use Psr\Http\Message\UriInterface;
use whm\Html\Document;

class HtmlAnchorAdapter implements Adapter
{
    private $content;
    private $baseUri;

    private $repairUrl;

    public function __construct(UriInterface $baseUri, $content, $repairUrl = true)
    {
        $this->content = (string)$content;
        $this->baseUri = $baseUri;
        $this->repairUrl = $repairUrl;
    }

    public function extract()
    {
        $contentWithoutScripts = Document::removeScriptTags($this->content);

        $htmlDocument = new Document($contentWithoutScripts, $this->repairUrl);

        return $htmlDocument->getOutgoingLinks($this->baseUri);
    }
}
