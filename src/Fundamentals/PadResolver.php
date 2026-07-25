<?php

declare(strict_types=1);

namespace Phigaki\Tar\Fundamentals;

final readonly class PadResolver
{
    public static function padNull(string $str, int $byteLength, PadOrder $order = PadOrder::RIGHT): string
    {
        return match ($order) {
            PadOrder::LEFT => str_pad($str, $byteLength, "\0", STR_PAD_LEFT),
            PadOrder::RIGHT => str_pad($str, $byteLength, "\0", STR_PAD_RIGHT),
        };
    }

    public static function padZero(string $str, int $byteLength, PadOrder $order = PadOrder::LEFT): string
    {
        return match ($order) {
            PadOrder::LEFT => str_pad($str, $byteLength, '0', STR_PAD_LEFT),
            PadOrder::RIGHT => str_pad($str, $byteLength, '0', STR_PAD_RIGHT),
        };
    }
}
