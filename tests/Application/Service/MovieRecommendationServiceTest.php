<?php

namespace App\Tests\Application\Service;

use App\Application\Service\MovieRecommendationService;
use App\Application\Strategy\MultiWordTitlesRecommendation;
use App\Application\Strategy\RandomMovieRecommendation;
use App\Application\Strategy\StartsWithWAndEvenRecommendation;
use App\Domain\Model\RecommendationCriteria;
use App\Domain\Movie;
use Symfony\Component\DependencyInjection\ServiceLocator;
use PHPUnit\Framework\TestCase;

class MovieRecommendationServiceTest extends TestCase
{
    private MovieRecommendationService $recommendationService;
    private ServiceLocator $serviceLocator;

    protected function setUp(): void
    {
        $randomStrategyMock = $this->createMock(RandomMovieRecommendation::class);
        $startsWithWStrategyMock = $this->createMock(StartsWithWAndEvenRecommendation::class);
        $multiWordTitlesStrategyMock = $this->createMock(MultiWordTitlesRecommendation::class);

        $this->serviceLocator = $this->createMock(ServiceLocator::class);
        
        $this->serviceLocator->method('get')->willReturnMap([
            ['random', $randomStrategyMock],
            ['starts_with_w_and_even', $startsWithWStrategyMock],
            ['multi_word_titles', $multiWordTitlesStrategyMock]
        ]);

        $this->recommendationService = new MovieRecommendationService($this->serviceLocator);
    }

    public function testRandomStrategyRecommendation(): void
    {
        $movies = [
            new Movie('The Matrix'),
            new Movie('Avatar'),
            new Movie('Titanic'),
        ];
        
        $randomStrategy = $this->serviceLocator->get('random');
        $randomStrategy->method('recomend')->willReturn([$movies[0]]);

        $recommendedMovies = $this->recommendationService->recomendMovies(RecommendationCriteria::RANDOM, $movies);

        $this->assertCount(1, $recommendedMovies);
        $this->assertSame('The Matrix', $recommendedMovies[0]->getTitle());
    }

    public function testStartsWithWAndEvenStrategyRecommendation(): void
    {
        $movies = [
            new Movie('The Matrix'),
            new Movie('Avatar'),
            new Movie('Wonder Woman'),
        ];

        $startsWithWStrategy = $this->serviceLocator->get('starts_with_w_and_even');
        $startsWithWStrategy->method('recomend')->willReturn([$movies[2]]);

        $recommendedMovies = $this->recommendationService->recomendMovies(RecommendationCriteria::STARTS_WITH_W_AND_EVEN, $movies);

        $this->assertCount(1, $recommendedMovies);
        $this->assertSame('Wonder Woman', $recommendedMovies[0]->getTitle());
    }

    public function testMultiWordTitlesRecommendation(): void
    {
        $movies = [
            new Movie('The Matrix'),
            new Movie('Avatar'),
            new Movie('Wonder Woman'),
        ];

        $multiWordStrategy = $this->serviceLocator->get('multi_word_titles');
        $multiWordStrategy->method('recomend')->willReturn([$movies[0], $movies[2]]); // "The Matrix" i "Wonder Woman" mają więcej niż jedno słowo

        $recommendedMovies = $this->recommendationService->recomendMovies(RecommendationCriteria::MULTI_WORD_TITLES, $movies);

        $this->assertCount(2, $recommendedMovies);
        $this->assertSame('The Matrix', $recommendedMovies[0]->getTitle());
        $this->assertSame('Wonder Woman', $recommendedMovies[1]->getTitle());
    }
}