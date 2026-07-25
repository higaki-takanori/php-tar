<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

// @see https://manpages.ubuntu.com/manpages/bionic/man5/tar.5.html#description

use Phigaki\Tar\Fundamentals\PadOrder;
use Phigaki\Tar\Fundamentals\PadResolver;

final readonly class FileSize
{
    public const int BYTE_LENGTH = 12;

    private function __construct(
        private int $size,
    ) {
    }

    public static function create(int $size): self
    {
        /**
         * @see https://manpages.ubuntu.com/manpages/bionic/man5/tar.5.html
         *
         * > Size of file, as octal number in ASCII.
         * > For regular files only, this indicates the amount of data that follows the header.
         * > In particular, this field was ignored by early tar implementations when extracting hardlinks.
         * > Modern writers should always store a zero length for hardlink entries.
         */
        return new self(size: $size);
    }

    public function toString(): string
    {
        return strval($this->size);
    }

    public function bytes(): string
    {
        $oct = decoct($this->size);
        $paddedOct = PadResolver::padZero($oct, self::BYTE_LENGTH - 1, PadOrder::LEFT);
        return PadResolver::padNull($paddedOct, self::BYTE_LENGTH, PadOrder::RIGHT);
    }
}
