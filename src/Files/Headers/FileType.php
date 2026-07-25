<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

use Exception;
use Phigaki\Tar\Fundamentals\PadOrder;
use Phigaki\Tar\Fundamentals\PadResolver;

/**
 * @see https://pubs.opengroup.org/onlinepubs/9799919799/utilities/pax.html#tagtcjh_21
 *
 * 0: Represents a regular file. For backwards-compatibility, a typeflag value of binary zero ('\0') should be recognized as meaning a regular file when extracting files from the archive. Archives written with this version of the archive file format create regular files with a typeflag value of the ISO/IEC 646:1991 standard IRV '0'.
 * 1: Represents a file linked to another file, of any type, previously archived. Such files are identified by having the same device and file serial numbers, and pathnames that refer to different directory entries. All such files shall be archived as linked files. The linked-to name is specified in the linkname field with a NUL-character terminator if it is less than 100 octets in length.
 * 2: Represents a symbolic link. The contents of the symbolic link shall be stored in the linkname field.
 * 3,4: Represent character special files and block special files respectively. In this case the devmajor and devminor fields shall contain information defining the device, the format of which is unspecified by this volume of POSIX.1-2024. Implementations may map the device specifications to their own local specification or may ignore the entry.
 * 5: Specifies a directory or subdirectory. On systems where disk allocation is performed on a directory basis, the size field shall contain the maximum number of octets (which may be rounded to the nearest disk block allocation unit) that the directory may hold. A size field of zero indicates no such limiting. Systems that do not support limiting in this manner should ignore the size field.
 * 6: Specifies a FIFO special file. Note that the archiving of a FIFO file archives the existence of this file and not its contents.
 * 7: Reserved to represent a file to which an implementation has associated some high-performance attribute. Implementations without such extensions should treat this file as a regular file (type 0).
 * A-Z: The letters 'A' to 'Z', inclusive, are reserved for custom implementations. All other values are reserved for future versions of this standard.
 */


enum FileType: int
{
    case RegularFile = 0;
    case HardLink = 1;
    case SymbolicLink = 2;
    case Character = 3;
    case Block = 4;
    case Directory = 5;
    case Fifo = 6;
    case Reserved = 7;
    case Other = -1;

    public const int BYTE_LENGTH = 1;

    public static function fromPath(string $path): self
    {
        // @see https://www.php.net/manual/ja/function.filetype.php
        $typeStr = filetype($path);
        if ($typeStr === false) {
            throw new Exception('指定したパスにファイルが見つかりませんでした。パスを確認してください。');
        }

        return match ($typeStr) {
            'block' => self::Block,
            'char' => self::Character,
            'dir' => self::Directory,
            'fifo' => self::Fifo,
            'file' => self::RegularFile,
            'link' => self::SymbolicLink,
            'unknown' => self::Other,
            default => self::Other,
        };
    }

    public function toString(): string
    {
        return decbin($this->value);
    }

    public function bytes(): string
    {
        return PadResolver::padNull((string)$this->value, self::BYTE_LENGTH, PadOrder::RIGHT);
    }
}
