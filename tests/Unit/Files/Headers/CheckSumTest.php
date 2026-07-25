<?php

use Phigaki\Tar\Files\Headers\CheckSum;
use Phigaki\Tar\Files\Headers\FileName;
use Phigaki\Tar\Files\Headers\FilePad;
use Phigaki\Tar\Files\Headers\FilePermission;
use Phigaki\Tar\Files\Headers\FileSize;
use Phigaki\Tar\Files\Headers\FileType;
use Phigaki\Tar\Files\Headers\Gid;
use Phigaki\Tar\Files\Headers\Link;
use Phigaki\Tar\Files\Headers\ModificationTime;
use Phigaki\Tar\Files\Headers\Uid;

describe('CheckSum', function () {
    describe('from', function () {
        it('パスを指定して作成できる', function () {
            $fileName = FileName::create('text.txt');
            $filePermission = FilePermission::from(664);
            $uid = Uid::create(1000);
            $gid = Gid::create(1000);
            $size = FileSize::create(44);
            $mtime = ModificationTime::from(1782601182);
            $link = Link::create(FileType::RegularFile, '');
            $pad = FilePad::create();

            $checkSum = CheckSum::from(
                fileName: $fileName,
                filePermission: $filePermission,
                uid: $uid,
                gid: $gid,
                fileSize: $size,
                mtime: $mtime,
                link: $link,
                pad: $pad,
            );
            expect($checkSum)->toBeInstanceOf(CheckSum::class);
        });
    });

    describe('bytes', function () {
        it('8bytesの長さで出力される', function () {
            $fileName = FileName::create('text.txt');
            $filePermission = FilePermission::from(33188);
            $uid = Uid::create(1000);
            $gid = Gid::create(1000);
            $size = FileSize::create(44);
            $mtime = ModificationTime::from(1782601182);
            $link = Link::create(FileType::RegularFile, '');
            $pad = FilePad::create();

            $checkSum = CheckSum::from(
                fileName: $fileName,
                filePermission: $filePermission,
                uid: $uid,
                gid: $gid,
                fileSize: $size,
                mtime: $mtime,
                link: $link,
                pad: $pad,
            );
            expect(strlen($checkSum->bytes()))->toEqual(8);
        });

        it('全てのheaderの合計値の8進数の値がchecksumとして出力される', function () {
            $fileName = FileName::create('hello.txt');
            $filePermission = FilePermission::from(33188);
            $uid = Uid::create(1000);
            $gid = Gid::create(1000);
            $size = FileSize::create(14);
            $mtime = ModificationTime::from(1783159132);
            $link = Link::create(FileType::RegularFile, '');
            $pad = FilePad::create();

            $checkSum = CheckSum::from(
                fileName: $fileName,
                filePermission: $filePermission,
                uid: $uid,
                gid: $gid,
                fileSize: $size,
                mtime: $mtime,
                link: $link,
                pad: $pad,
            );
            expect($checkSum->bytes())->toEqual(hex2bin('3030363430330020'));
        });
    });
});
