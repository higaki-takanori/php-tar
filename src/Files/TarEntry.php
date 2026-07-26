<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files;

use Phigaki\Tar\Files\Headers\FileType;
use Phigaki\Tar\Files\Headers\Header;

final readonly class TarEntry
{
    private function __construct(
        public Header $header,
        public ?FileContent $content,
    ) {
    }

    public static function from(string $path): self
    {
        $header = Header::create($path);

        $content = match ($header->getFileType()) {
            FileType::RegularFile => FileContent::from($path),
            default => null,
        };
        return new self(
            header: $header,
            content: $content,
        );
    }

    public function bytes(): string
    {
        return $this->header->bytes() . $this->content?->bytes();
    }
}
