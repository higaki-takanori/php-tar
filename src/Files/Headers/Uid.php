<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

// @see https://manpages.ubuntu.com/manpages/bionic/man5/tar.5.html#description

use Phigaki\Tar\Fundamentals\PadOrder;
use Phigaki\Tar\Fundamentals\PadResolver;

final readonly class Uid
{
    public const int BYTE_LENGTH = 8;

    private function __construct(
        private int $uid,
    ) {
    }

    public static function create(int $uid): self
    {
        return new self(uid: $uid);
    }

    public function toString(): string
    {
        return strval($this->uid);
    }

    public function bytes(): string
    {
        $oct = decoct($this->uid);
        $octPadded = PadResolver::padZero($oct, self::BYTE_LENGTH - 1, PadOrder::LEFT);
        return PadResolver::padNull($octPadded, self::BYTE_LENGTH, PadOrder::RIGHT);
    }
}
