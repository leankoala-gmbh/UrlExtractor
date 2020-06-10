<?php

namespace Leankoala\UrlExtractor\Adapter;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

/**
 * Class PdfAdapter
 *
 * This class is using the poppler-utils for converting PDF files into html documents. Afterwards
 * links are extracted from the HTML file.
 *
 * @see https://wiki.ubuntuusers.de/poppler-utils/
 *
 * @package Leankoala\UrlExtractor\Adapter
 *
 * @author Nils Langner (nils.langner@leankoala.com)
 */
class PdfAdapter implements Adapter
{
    private $content;

    public function __construct($content)
    {
        $this->content = (string)$content;
    }

    /**
     * @inheritDoc
     */
    public function extract()
    {
        $fileDir = sys_get_temp_dir() . '/';
        $fileName = $fileDir . time() . '.pdf';

        file_put_contents($fileName, $this->content);

        $command = 'pdftohtml -stdout -noframes "' . $fileName . '" 2>/dev/null ';

        exec($command, $output, $return);

        if ((int)$return == 127) {
            throw new AdapterException('Unable to find the cli tool "pdftohtml". Please install.');
        }

        $html = implode("\n", $output);

        $htmlAdapter = new HtmlAnchorAdapter(new Uri('https://www.example.com'), $html);

        /** @var UriInterface[] $htmlLinks */
        $htmlLinks = $htmlAdapter->extract();

        $links = [];

        foreach ($htmlLinks as $htmlLink) {
            if ($htmlLink->getHost() != "www.example.com") {
                $links[] = $htmlLink;
            }
        }

        return $links;
    }
}
