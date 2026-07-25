<?php


use Phigaki\Tar\Files\Headers\FileType;

describe('FileType', function () {
    describe('bytes', function () {
        it('1bytesの長さで出力される', function () {
            $fileType = FileType::RegularFile;

            expect(strlen($fileType->bytes()))->toEqual(1);
        });

        it('対応する数字がbinary文字列で出力される', function () {
            expect(FileType::RegularFile->bytes())->toEqual(hex2bin('30'));
            expect(FileType::Directory->bytes())->toEqual(hex2bin('35'));
        });
    });
});
