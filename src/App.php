<?php

namespace Phigaki\Tar;

use Phigaki\Tar\Files\Headers\Header;

final readonly class App
{
    public static function main(): void
    {
        $filePath = './files/sample.txt';

        $header = Header::create($filePath);

        var_dump($header);
        var_dump($header->bytes());
    }
}
