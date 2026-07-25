<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files\Headers;

use Exception;

final readonly class Header
{
    private function __construct(
        public FileName $fileName,
        public FilePermission $filePermission,
        public Uid $uid,
        public Gid $gid,
        public FileSize $fileSize,
        public ModificationTime $mtime,
        public FilePad $pad,
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
        $uid = Uid::create($meta["uid"]);
        $gid = Gid::create($meta["gid"]);
        $fileSize = FileSize::create($meta["size"]);
        $mtime = ModificationTime::from($meta["mtime"]);
        $pad = FilePad::create();

        return new self(
            fileName: $fileName,
            filePermission: $filePermission,
            uid: $uid,
            gid: $gid,
            fileSize: $fileSize,
            mtime: $mtime,
            pad: $pad,
        );
    }

    public function bytes(): string
    {
        return $this->fileName->bytes() .
            $this->filePermission->bytes() .
            $this->uid->bytes() .
            $this->gid->bytes() .
            $this->fileSize->bytes() .
            $this->mtime->bytes() .
            $this->pad->bytes();
    }
}
