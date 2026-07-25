<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

// @see https://pubs.opengroup.org/onlinepubs/9799919799/utilities/pax.html#tagtcjh_21

use DateTimeImmutable;
use Phigaki\Tar\Fundamentals\PadOrder;
use Phigaki\Tar\Fundamentals\PadResolver;

final readonly class ModificationTime
{
    public const int BYTE_LENGTH = 12;

    private function __construct(
        public DateTimeImmutable $time,
    ) {
    }

    public static function from(int $mtime): self
    {
        $datetime = DateTimeImmutable::createFromTimestamp($mtime);

        return new self(time: $datetime);
    }

    public function toString(): string
    {
        return (string) $this->time->getTimestamp();
    }

    public function bytes(): string
    {
        $oct = decoct($this->time->getTimestamp());
        $paddedOct = PadResolver::padZero($oct, self::BYTE_LENGTH - 1, PadOrder::LEFT);
        return PadResolver::padNull($paddedOct, self::BYTE_LENGTH, PadOrder::RIGHT);
    }
}
