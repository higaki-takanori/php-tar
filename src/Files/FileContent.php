<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files;

use Phigaki\Tar\Fundamentals\PadResolver;

final readonly class FileContent implements TarRecord
{
    public const int BYTE_LENGTH_UNIT = 512;

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
        // 512byteの区切りの長さに揃える
        $byteLength = (int)ceil(strlen($this->content) / self::BYTE_LENGTH_UNIT) * self::BYTE_LENGTH_UNIT;
        return PadResolver::padNull($this->content, $byteLength);
    }
}
