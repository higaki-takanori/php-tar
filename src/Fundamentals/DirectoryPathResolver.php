<?php

declare(strict_types=1);

namespace Phigaki\Tar\Fundamentals;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

final readonly class DirectoryPathResolver
{
    /**
     * @return string[]
     */
    public static function resolve(string $path): array
    {
        $result = [];
        if (is_dir($path)) {
            $directory = new RecursiveDirectoryIterator($path);
            $iterator = new RecursiveIteratorIterator($directory);

            foreach ($iterator as $file) {
                $result[] = $file->getPathname();
            }

            return $result;
        }
        return [$path];
    }
}