<?php

namespace App\Infrastructure\Presentation;

use App\Application\Service\MovieRecommendationService;
use App\Domain\Model\RecommendationCriteria;
use App\Infrastructure\Repository\StaticMovieRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:recommend-movies')]
class MovieRecommendationCommand extends Command
{
    private MovieRecommendationService $recommendationService;
    private StaticMovieRepository $movieRepository;

    public function __construct(
        MovieRecommendationService $recommendationService,
        StaticMovieRepository $movieRepository
    ) {
        parent::__construct();
        $this->recommendationService = $recommendationService;
        $this->movieRepository = $movieRepository;
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'strategy',
                InputArgument::REQUIRED,
                'The recommendation strategy to use (random, starts_with_w_and_even, more_than_one_word)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $movies = $this->movieRepository->findAll();

        if (empty($movies)) {
            $output->writeln('<fg=yellow>No movies found in the repository.</>');
            return Command::SUCCESS;
        }

        $criteria = RecommendationCriteria::fromString($input->getArgument('strategy'));

        if ($criteria === null) {
            $output->writeln('<fg=red>Invalid recommendation criteria. Please provide a valid strategy.</>');
            return Command::INVALID;
        }

        $recommendMovies = $this->recommendationService->recomendMovies($criteria, $movies);

        if (empty($recommendMovies)) {
            $output->writeln('<fg=orange>There are no recommendations for the specified criteria. </>');
        } else {
            $output->writeln(sprintf(
                '<fg=blue>"%s"</>',
                implode('", "', array_map(fn($movie) => $movie->getTitle(), $recommendMovies))
            ));
        }

        return Command::SUCCESS;
    }
}
