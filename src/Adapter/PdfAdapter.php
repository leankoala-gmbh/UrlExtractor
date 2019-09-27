<?php

namespace Leankoala\UrlExtractor\Adapter;

class PdfAdapter implements Adapter
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function extract()
    {
        $fileName = sys_get_temp_dir() . '/' . time() . '.pdf';

        file_put_contents($fileName, $this->content);

        $command = 'strings "' . $fileName . '" | grep "(http"';

        exec($command, $output, $return);

        $links = [];

        foreach ($output as $linkLine) {
            $httpPos = strpos($linkLine, 'http');
            $links[] = substr($linkLine, $httpPos, strlen($linkLine) - $httpPos - 1);
        }

        // TODO: Implement extract() method.
        unlink($fileName);

        return $links;
    }
}
