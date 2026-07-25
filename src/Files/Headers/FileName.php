<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

// @see https://manpages.ubuntu.com/manpages/bionic/man5/tar.5.html#description

use Phigaki\Tar\Fundamentals\PadOrder;
use Phigaki\Tar\Fundamentals\PadResolver;
use UnexpectedValueException;

final readonly class FileName
{
    public const int BYTE_LENGTH = 100;

    private function __construct(
        private string $name,
    ) {
        if (strlen($name) === 0) {
            throw new UnexpectedValueException('file name は 1文字以上指定する必要があります。');
        }
        if (strlen($name) > 100) {
            throw new UnexpectedValueException('file name は 100文字以下で設定してください。');
        }
    }

    public static function create(string $filePath): self
    {
        $pathInfo = pathinfo($filePath);

        $fileName = array_key_exists('dirname', $pathInfo) && $pathInfo['dirname'] != '.' ? $pathInfo['dirname'] . '/' . $pathInfo['basename'] : $pathInfo['basename'];

        return new self(name: $fileName);
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function bytes(): string
    {
        return PadResolver::padNull($this->name, self::BYTE_LENGTH, PadOrder::RIGHT);
    }
}
