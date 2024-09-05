<?php

namespace App\Application\Strategy;

use App\Domain\RecommendationServiceInterface;

class RandomMovieRecommendation implements RecommendationServiceInterface
{
    public function recomend(array $movies): array
    {
        shuffle($movies);
        return array_slice($movies, 0, 3);
    }
}
