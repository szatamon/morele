<?php
namespace App\Tests\Application\Strategy;

use App\Application\Strategy\RandomMovieRecommendation;
use App\Domain\Movie;
use PHPUnit\Framework\TestCase;

class RandomMovieRecommendationTest extends TestCase
{
    private RandomMovieRecommendation $strategy;

    protected function setUp(): void
    {
        $this->strategy = new RandomMovieRecommendation();
    }

    public function testRecomendReturnsThreeMovies(): void
    {
        $movie1 = new Movie('The Matrix');
        $movie2 = new Movie('Inception');
        $movie3 = new Movie('The Godfather');
        $movie4 = new Movie('Interstellar');
        $movie5 = new Movie('The Dark Knight');

        $movies = [$movie1, $movie2, $movie3, $movie4, $movie5];

        $recommendedMovies = $this->strategy->recomend($movies);

        $this->assertCount(3, $recommendedMovies, 'The strategy should return exactly 3 videos.');
    }

    public function testRecomendReturnsDifferentResultsOnSubsequentCalls(): void
    {
        $movie1 = new Movie('The Matrix');
        $movie2 = new Movie('Inception');
        $movie3 = new Movie('The Godfather');
        $movie4 = new Movie('Interstellar');
        $movie5 = new Movie('The Dark Knight');

        $movies = [$movie1, $movie2, $movie3, $movie4, $movie5];

        $firstRecommendation = $this->strategy->recomend($movies);
        $secondRecommendation = $this->strategy->recomend($movies);

        $this->assertNotEquals($firstRecommendation, $secondRecommendation, 'Two consecutive recommendations should not be the same.');
    }
}

