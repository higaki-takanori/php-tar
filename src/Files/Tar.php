<?php

declare(strict_types=1);

namespace Phigaki\Tar\Files;

final readonly class Tar
{
    private function __construct(
        /**
         * @var TarEntry[] $entries
         */
        public array $entries,
        public TarEndSign $endSign,
    ) {
    }

    /**
     * @param string[] $paths
     */
    public static function from(array $paths): self
    {
        $entries = [];

        foreach ($paths as $path) {
            $entries[] = TarEntry::from($path);
        }

        return new self(
            entries: $entries,
            endSign: TarEndSign::create(),
        );
    }

    public function save(string $fileName): void
    {
        file_put_contents($fileName, $this->bytes());
    }

    public function bytes(): string
    {
        $entryBytes = '';
        foreach ($this->entries as $entry) {
            $entryBytes = $entryBytes . $entry->bytes();
        }

        return $entryBytes . $this->endSign->bytes();
    }
}
