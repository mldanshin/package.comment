<?php

namespace Danshin\Comment\Repository;

use Danshin\Comment\Models\CommentRequest;

final class Repository
{
    private const SEPARATOR = "\n#############################################";

    public function __construct(private File $file)
    {
        $this->file->createIfNotExist();
    }

    /**
     * @return string[]
     */
    public function get(): array
    {
        $array = explode(self::SEPARATOR, $this->file->get());
        array_pop($array);
        return $array;
    }

    public function add(CommentRequest $comment): void
    {
        $this->file->append($this->convertToString($comment) . self::SEPARATOR);
    }

    public function count(): int
    {
        $content = $this->get();
        return count($content);
    }

    /**
     * @return string[]
     */
    public function cutFirst(int $length): array
    {
        if (!($length >= 1 && $length <= 1000)) {
            throw new \Exception("The $length parameter can have a value from 1 to 1000.");
        }

        $content = $this->get();
        $truncated = array_splice($content, 0, $length - 1);
        $this->file->put(implode(self::SEPARATOR, $content));
        return $truncated;
    }

    public function clear(): void
    {
        $this->file->clear();
    }

    private function convertToString(CommentRequest $comment): string
    {
        $email = ($comment->email === null) ? "" : $comment->email;
        $browser = ($comment->browser === null) ? "" : $comment->browser;
        return "date - {$comment->date->format('Y-m-d h:i:s')};\nname - $comment->name;\nemail - $email;\nmessage - $comment->content;\nip - $comment->ip;\nbrowser - $browser;";
    }
}
