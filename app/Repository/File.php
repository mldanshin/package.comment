<?php

namespace Danshin\Comment\Repository;

use Illuminate\Contracts\Filesystem\Filesystem;

final class File
{
    public const PART_DIR = "danshin";
    public const PART_PATH = "danshin/comment.txt";
    public readonly string $pathDirectory;
    public readonly string $path;
    public readonly Filesystem $disk;

    public function __construct(Filesystem $disk)
    {
        $this->disk = $disk;
        $this->pathDirectory = $disk->path(self::PART_DIR);
        $this->path = $disk->path(self::PART_PATH);

        $this->createDirectoryIfNotExist();
    }

    public function createIfNotExist(): void
    {
        if (!$this->disk->exists(self::PART_PATH)) {
            $this->disk->put(self::PART_PATH, '');
            chmod($this->path, 0777);
        }
    }

    public function get(): string
    {
        return $this->disk->get(self::PART_PATH);
    }

    public function append(string $content): void
    {
        $this->disk->append(
            self::PART_PATH,
            $content
        );
    }

    public function put(string $content): void
    {
        $this->disk->put(self::PART_PATH, $content);
    }

    public function clear(): void
    {
        $this->disk->put(self::PART_PATH, "");
    }

    private function createDirectoryIfNotExist(): void
    {
        if (!$this->disk->exists(self::PART_DIR)) {
            $this->disk->makeDirectory(self::PART_DIR);
            chmod($this->pathDirectory, 0777);
        }
    }
}
