<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

use Exception;

readonly final class Header
{
    private function __construct(
    )
    {
    }

    /**
     * @throws Exception
     */
    public static function create(string $filePath): self
    {
        // statの結果がキャッシュされることがあるのでクリアする
        clearstatcache();
        $meta = stat($filePath);

        if ($meta === false) {
            throw new Exception("ファイルのメタ情報の読み込みに失敗しました。{$filePath}を確認してください。");
        }

        return new self();
    }

    public function bytes(): string
    {
        return '';
    }
}