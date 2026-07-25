<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files;

use Phigaki\Tar\Files\Headers\Header;

final readonly class TarEntry
{
    private function __construct(
        public Header       $header,
        public ?FileContent $content,
    ) {
    }

    public static function from(string $path): self
    {
        return new self(
            header: Header::create($path),
            content: FileContent::from($path),
        );
    }

    public function bytes(): string
    {
        return $this->header->bytes() . $this->content?->bytes();
    }
}
