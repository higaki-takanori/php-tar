<?php


use Phigaki\Tar\Files\Headers\Gid;

describe('Gid', function () {
    describe('create', function () {
        it('数値から作成できる', function () {
            $Gid = Gid::create(1000);

            expect($Gid)->toBeInstanceOf(Gid::class);
        });
    });

    describe('toString', function () {
        it('10進数で出力される', function () {
            $Gid = Gid::create(1000);

            expect($Gid->toString())->toEqual('1000');
        });
    });

    describe('bytes', function () {
        it('8bytesの長さで出力される', function () {
            $Gid = Gid::create(1000);

            expect(strlen($Gid->bytes()))->toEqual(8);
        });

        it('8進数に変換後binary文字列で出力される', function () {
            $Gid = Gid::create(1000);

            // 0|0|0|1|0|0|0|NULL = 0x30|30|30|31|37|35|30|00 = "0o0|0|0|1|7|5|0|NULL"
            expect($Gid->bytes())->toEqual(hex2bin('3030303137353000'));
        });
    });
});
