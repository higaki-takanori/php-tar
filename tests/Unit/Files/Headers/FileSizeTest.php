<?php


use Phigaki\Tar\Files\Headers\FileSize;

describe('FileSize', function () {
    describe('create', function () {
        it('数値から作成できる', function () {
            $FileSize = FileSize::create(1000);

            expect($FileSize)->toBeInstanceOf(FileSize::class);
        });
    });

    describe('toString', function () {
        it('10進数で出力される', function () {
            $FileSize = FileSize::create(1000);

            expect($FileSize->toString())->toEqual('1000');
        });
    });

    describe('bytes', function () {
        it('12bytesの長さで出力される', function () {
            $FileSize = FileSize::create(1000);

            expect(strlen($FileSize->bytes()))->toEqual(12);
        });

        it('8進数に変換後binary文字列で出力される', function () {
            $FileSize = FileSize::create(1000);

            // 0|0|0|0|0|0|0|1|0|0|0|space = 0x30|30|30|30|30|30|30|31|37|35|30|20 = "0o0|0|0|0|0|0|0|1|7|5|0|space"
            expect($FileSize->bytes())->toEqual(hex2bin('303030303030303137353020'));
        });
    });
});
