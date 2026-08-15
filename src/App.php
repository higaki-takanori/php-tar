<?php

namespace Phigaki\Tar;

use Exception;
use Phigaki\Tar\Files\Tar;
use Phigaki\Tar\Fundamentals\DirectoryPathResolver;
use UnexpectedValueException;

final readonly class App
{
    /** @param string[] $argv */
    public static function main(int $argc, array $argv): void
    {
        $argvFilePaths = match ($argc) {
            0 => throw new UnexpectedValueException('想定し得ない値が入力されました。'),
            1 => throw new Exception('保存する tarball のファイル名を指定してください。'),
            2 => throw new Exception('tarball に格納するファイルを指定してください。'),
            default => array_slice($argv, 2),
        };
        $outputName = $argv[1];

        $targetFilePaths = [];
        foreach ($argvFilePaths as $filePath) {
            $targetFilePaths = [...$targetFilePaths, ...DirectoryPathResolver::resolve($filePath)];
        }

        $tar = Tar::from($targetFilePaths);
        $tar->save($outputName);
    }
}
