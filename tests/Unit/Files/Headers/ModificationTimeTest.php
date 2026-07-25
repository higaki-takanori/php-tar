<?php

use Phigaki\Tar\Files\Headers\ModificationTime;

describe('ModificationTime', function () {
    describe('from', function () {
        it('timestampから作成できる', function () {
            // 1783159132 -> 日時（Tokyo）＝2026/07/04 18:58:52
            $modificationTime = ModificationTime::from(1783159132);

            expect($modificationTime)->toBeInstanceOf(ModificationTime::class);
        });
    });

    describe('toString', function () {
        it('timestampが出力できる', function () {
            $modificationTime = ModificationTime::from(1783159132);

            expect($modificationTime->toString())->toEqual('1783159132');
        });
    });

    describe('bytes', function () {
        it('12bytesの長さで出力される', function () {
            $modificationTime = ModificationTime::from(1783159132);

            expect(strlen($modificationTime->bytes()))->toEqual(12);
        });

        it('8進数表記で先頭は0の文字列で末端はspace or NULL 埋めで出力される', function () {
            $modificationTime = ModificationTime::from(1783159132);

            expect($modificationTime->bytes())->toEqual(hex2bin('313532323231353435333400'));
        });
    });
});
