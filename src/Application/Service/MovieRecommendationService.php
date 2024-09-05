<?php

namespace App\Application\Service;

use App\Domain\Model\RecommendationCriteria;
use Symfony\Component\DependencyInjection\ServiceLocator;

class MovieRecommendationService
{
    private ServiceLocator $serviceLocator;

    public function __construct(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function recomendMovies(RecommendationCriteria $strategyEnum, array $movies): array
    {
        $strategy = $this->serviceLocator->get($strategyEnum->value);
        return $strategy->recomend($movies);
    }
}
