<?php


use Phigaki\Tar\Files\Headers\FileType;
use Phigaki\Tar\Files\Headers\Link;

describe('Link', function () {
    describe('create', function () {
        it('レギュラーファイルを作成できる', function () {
            $link = Link::create(FileType::RegularFile, '');

            expect($link)->toBeInstanceOf(Link::class);
        });
    });

    describe('toString', function () {
        it('10進数で出力される', function () {
            $link = Link::create(FileType::RegularFile, '');

            expect($link->toString())->toEqual('0');
        });
    });

    describe('bytes', function () {
        it('101bytesの長さで出力される', function () {
            $link = Link::create(FileType::RegularFile, '');

            expect(strlen($link->bytes()))->toEqual(101);
        });

        it('レギュラーファイルは全てnullで出力される', function () {
            $link = Link::create(FileType::RegularFile, '');

            expect($link->bytes())->toEqual(hex2bin('0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'));
        });
    });
});
