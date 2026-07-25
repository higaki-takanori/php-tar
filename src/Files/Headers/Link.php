<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

// @see https://manpages.ubuntu.com/manpages/bionic/man5/tar.5.html

use Exception;
use Phigaki\Tar\Fundamentals\PadOrder;
use Phigaki\Tar\Fundamentals\PadResolver;

final readonly class Link
{
    public const int BYTE_LENGTH = 101;

    private function __construct(
        private FileType $fileType,
        private ?string $linkName,
    ) {
    }

    public static function create(FileType $fileType, string $linkName): self
    {
        return match ($fileType) {
            FileType::RegularFile => new self(
                fileType: FileType::RegularFile,
                linkName: null,
            ),
            default => throw new Exception('未実装です。'),
        };
    }

    public function toString(): string
    {
        return $this->fileType->toString() . $this->linkName;
    }

    public function bytes(): string
    {
        return match ($this->fileType) {
            FileType::RegularFile => PadResolver::padNull('', self::BYTE_LENGTH, PadOrder::RIGHT),
            default => throw new Exception('未実装です。'),
        };
    }
}
