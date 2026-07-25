<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

// @see https://manpages.ubuntu.com/manpages/bionic/man5/tar.5.html#description

use Phigaki\Tar\Fundamentals\PadOrder;
use Phigaki\Tar\Fundamentals\PadResolver;

final readonly class Gid
{
    public const int BYTE_LENGTH = 8;

    private function __construct(
        private int $gid,
    ) {
    }

    public static function create(int $gid): self
    {
        return new self(gid: $gid);
    }

    public function toString(): string
    {
        return strval($this->gid);
    }

    public function bytes(): string
    {
        $oct = decoct($this->gid);
        $octPadded = PadResolver::padZero($oct, self::BYTE_LENGTH - 1, PadOrder::LEFT);
        return PadResolver::padNull($octPadded, self::BYTE_LENGTH, PadOrder::RIGHT);
    }
}
