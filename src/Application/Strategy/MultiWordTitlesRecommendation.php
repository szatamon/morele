<?php

namespace App\Application\Strategy;

use App\Domain\RecommendationServiceInterface;

class MultiWordTitlesRecommendation implements RecommendationServiceInterface
{
    public function recomend(array $movies): array
    {
        return array_values(array_filter($movies, function ($movie) {
            return $movie->isMultiWordTitle();
        }));
    }
}
