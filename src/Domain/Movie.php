<?php

namespace App\Domain;

final readonly class Movie
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTitleLength(): int
    {
        return strlen($this->title);
    }

    public function isMultiWordTitle(): bool
    {
        return str_contains($this->title, ' ');
    }
}
