<?php
namespace App\Tests\Application\Strategy;

use App\Application\Strategy\MultiWordTitlesRecommendation;
use App\Domain\Movie;
use PHPUnit\Framework\TestCase;

class MultiWordTitlesRecommendationTest extends TestCase
{
    private MultiWordTitlesRecommendation $strategy;

    protected function setUp(): void
    {
        $this->strategy = new MultiWordTitlesRecommendation();
    }

    public function testRecomendReturnsMoviesWithMultiWordTitles(): void
    {
        $movie1 = new Movie('The Matrix');
        $movie2 = new Movie('Inception');
        $movie3 = new Movie('The Godfather'); 

        $movies = [$movie1, $movie2, $movie3];

        $recommendedMovies = $this->strategy->recomend($movies);

        $this->assertCount(2, $recommendedMovies, 'The strategy should return only videos with multi-word titles.');
        $this->assertSame($movie1, $recommendedMovies[0], 'The first movie should have been "The Matrix".');
        $this->assertSame($movie3, $recommendedMovies[1], 'The second movie should be "The Godfather".');
    }

    public function testRecomendReturnsEmptyArrayWhenNoMultiWordTitles(): void
    {
        $movie1 = new Movie('Avatar');
        $movie2 = new Movie('Inception');

        $movies = [$movie1, $movie2];

        $recommendedMovies = $this->strategy->recomend($movies);

        $this->assertCount(0, $recommendedMovies, 'Should return an empty array if there are no movies with multi-word titles.');
    }
}
