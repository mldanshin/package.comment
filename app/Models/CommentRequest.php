<?php

namespace Danshin\Comment\Models;

final class CommentRequest
{
    public readonly string $ip;
    public readonly ?string $browser;
    public readonly \DateTime $date;
    public readonly string $name;
    public readonly ?string $email;
    public readonly string $content;

    public function __construct(
        string $ip,
        ?string $browser,
        \DateTime $date,
        string $name,
        ?string $email,
        string $content
    ) {
        $this->ip = $ip;
        $this->browser = $browser;
        $this->date = $date;
        $this->name = $name;
        $this->email = $email;
        $this->content = $content;
    }
}
