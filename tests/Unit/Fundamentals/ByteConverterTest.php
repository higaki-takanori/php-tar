<?php

use Phigaki\Tar\Fundamentals\ByteConverter;

describe('ByteConverter', function () {
    describe('bin2oct', function () {
        it('2進数の文字列を8進数の数値に変換できる', function () {
            // 110100100 (2進数) = 644 (8進数)
            expect(ByteConverter::bin2oct('110100100'))->toEqual(644);
            // 111 (2進数) = 7 (8進数)
            expect(ByteConverter::bin2oct('111'))->toEqual(7);
        });
    });
});
