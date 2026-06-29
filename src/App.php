<?php

namespace Phigaki\Tar;

final readonly class App
{
    public static function main(): void
    {
        $file = './files/sample.txt';

        $uid = fileowner($file);
        $gid = filegroup($file);

        var_dump("UID: {$uid}");
        var_dump("GID: {$gid}");
    }
}