<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

// @see https://manpages.ubuntu.com/manpages/bionic/man5/tar.5.html#description

use Phigaki\Tar\Fundamentals\ByteConverter;
use Phigaki\Tar\Fundamentals\PadOrder;
use Phigaki\Tar\Fundamentals\PadResolver;

final readonly class FilePermission
{
    public const int BYTE_LENGTH = 8;

    private function __construct(
        private int $owner,
        private int $group,
        private int $other,
    ) {
    }

    public static function from(int $decNum): self
    {
        // 権限に必要な箇所以外を捨てる。足りない場合は0埋め
        // 例: 0b1000000110100101 -> owner 110, group 100, other 101
        $binary = str_pad(decbin($decNum), 9, '0', STR_PAD_LEFT);

        // 文字列を数値に変換する
        // 例: owner 0b110, group 0b100, other 0b101 -> owner 6, group 4, other 5
        $ownerStr = substr($binary, -9, 3);
        $groupStr = substr($binary, -6, 3);
        $otherStr = substr($binary, -3, 3);

        return new self(
            owner: ByteConverter::bin2oct($ownerStr),
            group: ByteConverter::bin2oct($groupStr),
            other: ByteConverter::bin2oct($otherStr),
        );
    }

    public function toString(): string
    {
        return $this->owner . $this->group . $this->other;
    }

    public function bytes(): string
    {
        // @see https://manpages.ubuntu.com/manpages/bionic/man5/tar.5.html
        // > POSIX requires numeric fields to be zero-padded in the front, and requires them to be terminated with either space or NUL characters.
        $padded = PadResolver::padZero($this->toString(), self::BYTE_LENGTH - 1, PadOrder::LEFT);

        return PadResolver::padNull($padded, self::BYTE_LENGTH, PadOrder::RIGHT);
    }
}
