<?php

use Phigaki\Tar\Fundamentals\DirectoryPathResolver;

describe('DirectoryPathResolver', function () {
    describe('resolve', function () {
        it('指定したpathがディレクトリでない場合は指定したpathの配列が返却される', function () {
            $path = '/path/to/not-a-directory/file.txt';

            expect(DirectoryPathResolver::resolve($path))->toEqual([$path]);
        });

        it('指定したpathがディレクトリの場合はディレクトリの内容のpathの配列が返却される', function () {
            $path = sys_get_temp_dir() . '/' . uniqid('directory-path-resolver-test-', true);
            mkdir($path . '/nested', recursive: true);
            file_put_contents($path . '/file1.txt', 'file1');
            file_put_contents($path . '/nested/file2.txt', 'file2');

            $result = DirectoryPathResolver::resolve($path);

            expect($result)
                ->toBeArray()
                ->toContain($path . '/file1.txt')
                ->toContain($path . '/nested/file2.txt');

            unlink($path . '/file1.txt');
            unlink($path . '/nested/file2.txt');
            rmdir($path . '/nested');
            rmdir($path);
        });

        it('指定したpathが相対パスの場合はディレクトリの内容のpathの配列が返却される', function () {
            $path = 'directory-path-resolver-test-relative-' . uniqid();
            mkdir($path . '/nested', recursive: true);
            file_put_contents($path . '/file1.txt', 'file1');
            file_put_contents($path . '/nested/file2.txt', 'file2');

            $result = DirectoryPathResolver::resolve($path);

            expect($result)
                ->toBeArray()
                ->toContain($path . '/file1.txt')
                ->toContain($path . '/nested/file2.txt');

            unlink($path . '/file1.txt');
            unlink($path . '/nested/file2.txt');
            rmdir($path . '/nested');
            rmdir($path);
        });

        it('指定したpathが多重ネストのディレクトリの場合はディレクトリの内容のpathの配列が返却される', function () {
            $path = sys_get_temp_dir() . '/' . uniqid('directory-path-resolver-test-nested-', true);
            mkdir($path . '/level1/level2/level3', recursive: true);
            file_put_contents($path . '/file1.txt', 'file1');
            file_put_contents($path . '/level1/file2.txt', 'file2');
            file_put_contents($path . '/level1/level2/file3.txt', 'file3');
            file_put_contents($path . '/level1/level2/level3/file4.txt', 'file4');

            $result = DirectoryPathResolver::resolve($path);

            expect($result)
                ->toBeArray()
                ->toContain($path . '/file1.txt')
                ->toContain($path . '/level1/file2.txt')
                ->toContain($path . '/level1/level2/file3.txt')
                ->toContain($path . '/level1/level2/level3/file4.txt');

            unlink($path . '/file1.txt');
            unlink($path . '/level1/file2.txt');
            unlink($path . '/level1/level2/file3.txt');
            unlink($path . '/level1/level2/level3/file4.txt');
            rmdir($path . '/level1/level2/level3');
            rmdir($path . '/level1/level2');
            rmdir($path . '/level1');
            rmdir($path);
        });
    });
});
