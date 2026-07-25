<?php

use Phigaki\Tar\Files\Headers\FileName;

describe('FileName', function () {
    describe('create', function () {
        it('長さ0で指定できない', function () {
            $name = '';
            FileName::create($name);
        })->throws(Exception::class);

        it('長さ100以上を指定できない', function () {
            $name = str_repeat('a', 101);
            FileName::create($name);
        })->throws(Exception::class);

        it('長さ1で指定できる', function () {
            $name = 'a';
            $fileName = FileName::create($name);
            expect($fileName)->toBeInstanceOf(FileName::class);
        });

        it('長さ100以下で指定できる', function () {
            $name = str_repeat('a', 100);
            $fileName = FileName::create($name);
            expect($fileName)->toBeInstanceOf(FileName::class);
        });

        it('パスを指定して作成できる', function () {
            $filePath = './hoge/text.txt';
            $fileName = FileName::create($filePath);
            expect($fileName)->toBeInstanceOf(FileName::class);
        });
    });

    describe('toString', function () {
        it('パスが . の時はファイル名のに出力される', function () {
            $filePath = 'text.txt';
            $fileName = FileName::create($filePath);
            expect($fileName->toString())->toEqual('text.txt');
        });

        it('パスがそのまま出力される', function () {
            $filePath = './hoge/text.txt';
            $fileName = FileName::create($filePath);
            expect($fileName->toString())->toEqual('./hoge/text.txt');
        });
    });

    describe('bytes', function () {
        it('100bytesの長さで出力される', function () {
            $filePath = 'text.txt';
            $fileName = FileName::create($filePath);
            $bytes = $fileName->bytes();
            expect(strlen($bytes))->toEqual(100);
        });

        it('あまりのbyteは0で埋められる', function () {
            $filePath = 'text.txt';
            $fileName = FileName::create($filePath);
            $bytes = $fileName->bytes();
            expect($bytes)->toEqual(hex2bin('746578742e7478740000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'));
        });
    });
});
