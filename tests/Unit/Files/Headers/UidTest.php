<?php


use Phigaki\Tar\Files\Headers\Uid;

describe('Uid', function () {
    describe('create', function () {
        it('数値から作成できる', function () {
            $uid = Uid::create(1000);

            expect($uid)->toBeInstanceOf(Uid::class);
        });
    });

    describe('toString', function () {
        it('10進数で出力される', function () {
            $uid = Uid::create(1000);

            expect($uid->toString())->toEqual('1000');
        });
    });

    describe('bytes', function () {
        it('8bytesの長さで出力される', function () {
            $uid = Uid::create(1000);

            expect(strlen($uid->bytes()))->toEqual(8);
        });

        it('8進数に変換後binary文字列で出力される', function () {
            $uid = Uid::create(1000);

            // 0|0|0|1|0|0|0|NULL = 0x30|30|30|31|37|35|30|00 = "0o0|0|0|1|7|5|0|NULL"
            expect($uid->bytes())->toEqual(hex2bin('3030303137353000'));
        });
    });
});
