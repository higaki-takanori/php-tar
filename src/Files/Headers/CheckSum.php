<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

use Exception;
use Phigaki\Tar\Fundamentals\PadOrder;
use Phigaki\Tar\Fundamentals\PadResolver;

final readonly class CheckSum
{
    public const int BYTE_LENGTH = 8;

    private function __construct(
        private string $checksum,
    ) {
    }

    public static function from(
        FileName $fileName,
        FilePermission $filePermission,
        Uid $uid,
        Gid $gid,
        FileSize $fileSize,
        ModificationTime $mtime,
        Link $link,
        FilePad $pad,
    ): self {
        $dec = self::byte2checksum($fileName->bytes()) +
            self::byte2checksum($filePermission->bytes()) +
            self::byte2checksum($uid->bytes()) +
            self::byte2checksum($gid->bytes()) +
            self::byte2checksum($fileSize->bytes()) +
            self::byte2checksum($mtime->bytes()) +
            256 + // checksumの部分は導出時は全て" "として扱う 0x20(32) * 8 = 256
            self::byte2checksum($link->bytes()) +
            self::byte2checksum($pad->bytes());

        return new self(checksum: decoct($dec));
    }

    public function toString(): string
    {
        return $this->checksum;
    }

    public function bytes(): string
    {
        $padded = PadResolver::padZero($this->checksum, self::BYTE_LENGTH - 2, PadOrder::LEFT);
        return PadResolver::padNull($padded, self::BYTE_LENGTH - 1, PadOrder::RIGHT) . ' ';
    }

    /**
     * bytes から CheckSum 計算する
     *
     * 例) FilePermission
     * binary表記: '0'|'0'|'0'|'0'|'6'|'4'|'4'|NULL
     * 16進数表記: 30|30|30|30|36|34|34|00
     * => CheckSum: 30+30+30+30+36+34+34+00 = 224
     */
    private static function byte2checksum(string $bytes): int
    {
        // 例) $array = [30,30,30,30,36,34,34,0]
        $array = unpack('C*', $bytes);
        if ($array === false) {
            throw new Exception('予期せぬエラーが発生しました。byteを配列に変換できませんでした。');
        }
        // 例) 30+30+30+30+36+34+34+0 = 224
        return array_sum($array);
    }
}
