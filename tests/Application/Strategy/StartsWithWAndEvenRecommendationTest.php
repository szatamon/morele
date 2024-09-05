<?php

namespace App\Tests\Application\Strategy;

use App\Application\Strategy\StartsWithWAndEvenRecommendation;
use App\Domain\Movie;
use PHPUnit\Framework\TestCase;

class StartsWithWAndEvenRecommendationTest extends TestCase
{
    private StartsWithWAndEvenRecommendation $strategy;

    protected function setUp(): void
    {
        $this->strategy = new StartsWithWAndEvenRecommendation();
    }

    public function testRecomendReturnsMoviesStartingWithWAndEvenLength(): void
    {
        $movie1 = new Movie('Wonder Woman');
        $movie2 = new Movie('Warrior');
        $movie3 = new Movie('Inception');
        $movie4 = new Movie('World War Z');
        $movie5 = new Movie('The Matrix');

        $movies = [$movie1, $movie2, $movie3, $movie4, $movie5];

        $recommendedMovies = $this->strategy->recomend($movies);

        $this->assertCount(1, $recommendedMovies, 'Only one video should be returned.');
        $this->assertSame($movie1, $recommendedMovies[0], 'The movie should be "Wonder Woman".');
    }

    public function testRecomendReturnsNoMoviesIfNoMatch(): void
    {
        $movie1 = new Movie('Inception');
        $movie2 = new Movie('Warrior');
        $movie3 = new Movie('Matrix');

        $movies = [$movie1, $movie2, $movie3];

        $recommendedMovies = $this->strategy->recomend($movies);

        $this->assertCount(0, $recommendedMovies, 'No film should be returned.');
    }
}
