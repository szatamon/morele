<?php

namespace App\Infrastructure\Repository;

use App\Domain\Movie;

class StaticMovieRepository
{
    private array $movies;

    public function __construct()
    {
        $this->movies = include __DIR__ . '/../movies.php';
    }

    public function findAll(): array
    {
        return array_map(fn($title) => new Movie($title), $this->movies);
    }
}
