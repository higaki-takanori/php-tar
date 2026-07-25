<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files;

use Phigaki\Tar\Fundamentals\PadResolver;

final readonly class TarEndSign
{
    public const int BYTE_LENGTH = 512 * 2;

    private function __construct(
        public string $zeroRecord,
    ) {
    }

    public static function create(): self
    {
        return new self(zeroRecord: PadResolver::padNull('', self::BYTE_LENGTH));
    }

    public function bytes(): string
    {
        return $this->zeroRecord;
    }
}
