<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

use Phigaki\Tar\Fundamentals\PadOrder;
use Phigaki\Tar\Fundamentals\PadResolver;

final readonly class FilePad
{
    public const int BYTE_LENGTH = 255;

    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function toString(): string
    {
        return '';
    }

    public function bytes(): string
    {
        return PadResolver::padNull('', self::BYTE_LENGTH, PadOrder::RIGHT);
    }
}
