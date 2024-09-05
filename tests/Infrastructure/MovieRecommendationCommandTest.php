<?php

namespace App\Tests\Infrastructure;

use App\Application\Service\MovieRecommendationService;
use App\Domain\Movie;
use App\Infrastructure\Presentation\MovieRecommendationCommand;
use App\Infrastructure\Repository\StaticMovieRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class MovieRecommendationCommandTest extends TestCase
{
    private $recommendationService;
    private $movieRepository;
    private $command;

    protected function setUp(): void
    {
        $this->recommendationService = $this->createMock(MovieRecommendationService::class);
        $this->movieRepository = $this->createMock(StaticMovieRepository::class);
        $this->command = new MovieRecommendationCommand($this->recommendationService, $this->movieRepository);
    }

    public function testExecuteWithValidCriteria(): void
    {
        $commandTester = new CommandTester($this->command);
        $commandTester->setInputs(['random']);

        $movie = new Movie('The Matrix');
        $this->movieRepository->method('findAll')->willReturn([$movie]);
        $this->recommendationService->method('recomendMovies')->willReturn([$movie]);

        $commandTester->execute(['strategy' => 'random']);

        $this->assertStringContainsString('The Matrix', $commandTester->getDisplay());
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    
    }

    public function testExecuteWithInvalidCriteria(): void
    {
        $commandTester = new CommandTester($this->command);
        $movie = new Movie('The Matrix');
        $this->movieRepository->method('findAll')->willReturn([$movie]);
        $this->recommendationService->expects($this->never())->method('recomendMovies');

        $commandTester->execute(['strategy' => 'invalid_strategy']);

        $this->assertStringContainsString('Invalid recommendation criteria. Please provide a valid strategy', $commandTester->getDisplay());
        $this->assertEquals(Command::INVALID, $commandTester->getStatusCode());
    }

    public function testExecuteWithNoRecommendations(): void
    {
        $commandTester = new CommandTester($this->command);

        $this->movieRepository->method('findAll')->willReturn([]);
        $this->recommendationService->method('recomendMovies')->willReturn([]);

        $commandTester->execute(['strategy' => 'random']);

        $this->assertStringContainsString('No movies found in the repository', $commandTester->getDisplay());
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }


}