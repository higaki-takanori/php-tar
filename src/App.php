<?php

namespace Phigaki\Tar;

use Phigaki\Tar\Files\Tar;

final readonly class App
{
    public static function main(): void
    {
        $filePath1 = './files/sample.txt';
        $filePath2 = './files/sample2.txt';
        $filePath3 = './files/directory/';

        $tar = Tar::from([$filePath1, $filePath2, $filePath3]);
        $tar->save('sample.php.tar');
    }
}
