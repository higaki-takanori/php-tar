<?php

namespace Phigaki\Tar;

use Phigaki\Tar\Files\Tar;

final readonly class App
{
    public static function main(): void
    {
        $filePath = './files/sample.txt';

        $tar = Tar::from([$filePath]);
        $tar->save('sample.tar');
    }
}
