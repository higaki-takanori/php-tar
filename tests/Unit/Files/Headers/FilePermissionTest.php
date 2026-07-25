<?php

use Phigaki\Tar\Files\Headers\FilePermission;

describe('FilePermission', function () {
    describe('from', function () {
        it('modeで取得できる数値から作成できる', function () {
            // 0b1000000110100100 = 33188
            $permission = FilePermission::from(33188);

            expect($permission)->toBeInstanceOf(FilePermission::class);
        });


        it('extracts permission bits even when the value has fewer than 9 bits', function (
            int $mode,
            string $expected,
        ) {
            expect(FilePermission::from($mode)->toString())->toBe($expected);
        })->with([
            'common 0644' => [33188, '644'],
            'common 0755' => [0755, '755'],
            'owner-only write 0200' => [0200, '200'], // 修正前は "400"
            'group+other read 0044' => [0044, '044'], // 修正前は "444"
            'other read 0004' => [0004, '004'], // 修正前は "444"
            'zero 0000' => [0000, '000'],
        ]);
    });

    describe('toString', function () {
        it('owner、group、otherそれぞれを連結して8進数として出力できる', function () {
            // 0b1000000110100100 = 33188
            $permission = FilePermission::from(33188);

            expect($permission->toString())->toEqual('644');
        });
    });

    describe('bytes', function () {
        it('8bytesの長さで出力される', function () {
            // 0b1000000110100100 = 33188
            $permission = FilePermission::from(33188);

            expect(strlen($permission->bytes()))->toEqual(8);
        });

        it('先頭は0の文字列で末端はspace or NULL 埋めで出力される', function () {
            // 0b1000000110100100 = 33188
            $permission = FilePermission::from(33188);

            // 0x30|30|30|30|36|34|34|00 = "0|0|0|0|6|4|4|NULL"
            expect($permission->bytes())->toEqual(hex2bin('3030303036343400'));
        });
    });
});
