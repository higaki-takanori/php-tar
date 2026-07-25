<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files;

use Phigaki\Tar\Fundamentals\PadResolver;

final readonly class FileContent implements TarRecord
{
    public const int BYTE_LENGTH = 512;

    private function __construct(
        public string $content,
    ) {
    }

    public static function from(string $path): self
    {
        if (! is_file($path) || ! is_readable($path)) {
            throw new \RuntimeException("読み取り不可のファイルです。: {$path}");
        }

        $content = file_get_contents($path);
        if ($content === false) {
            throw new \RuntimeException("ファイルの読み取りに失敗しました。: {$path}");
        }

        return new self(content: $content);
    }

    public function bytes(): string
    {
        return PadResolver::padNull($this->content, self::BYTE_LENGTH);
    }
}
