<?php

namespace Phigaki\Tar;

use Phigaki\Tar\Files\FileContent;
use Phigaki\Tar\Files\Headers\Header;

final readonly class App
{
    public static function main(): void
    {
        $filePath = './files/sample.txt';

        $header = Header::create($filePath);
        $content = FileContent::from($filePath);

        var_dump($header);
        var_dump($header->bytes());
        var_dump($content);
        var_dump($content->bytes());
    }
}
