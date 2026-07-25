<?php


use Phigaki\Tar\Files\Headers\FilePad;

describe('FilePad', function () {
    describe('create', function () {
        it('引数なしで作成できる', function () {
            $filePad = FilePad::create();

            expect($filePad)->toBeInstanceOf(FilePad::class);
        });
    });

    describe('toString', function () {
        it('10進数で出力される', function () {
            $filePad = FilePad::create();

            expect($filePad->toString())->toEqual('');
        });
    });

    describe('bytes', function () {
        it('255bytesの長さで出力される', function () {
            $filePad = FilePad::create();

            expect(strlen($filePad->bytes()))->toEqual(255);
        });

        it('8進数に変換後binary文字列で出力される', function () {
            $filePad = FilePad::create();

            expect($filePad->bytes())->toEqual(hex2bin('000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'));
        });
    });
});
