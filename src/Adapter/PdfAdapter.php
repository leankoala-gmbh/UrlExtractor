<?php

namespace Leankoala\UrlExtractor\Adapter;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class PdfAdapter implements Adapter
{
    private $content;

    public function __construct($content)
    {
        $this->content = (string)$content;
    }

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
