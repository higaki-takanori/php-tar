<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

use Exception;

final readonly class Header
{
    private function __construct(
        public FileName $fileName,
        public FilePermission $filePermission,
    ) {
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

        $fileName = FileName::create($filePath);
        $filePermission = FilePermission::from($meta["mode"]);

        return new self(
            fileName: $fileName,
            filePermission: $filePermission,
        );
    }

    public function bytes(): string
    {
        return $this->fileName->bytes() .
            $this->filePermission->bytes();
    }
}
