<?php

declare(strict_types=1);

namespace Phigaki\Tar\Fundamentals;

final readonly class ByteConverter
{
    public static function bin2oct(string $bin): int
    {
        return (int) decoct((int) bindec($bin));
    }
}
