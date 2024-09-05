<?php

namespace App\Application\Strategy;

use App\Domain\RecommendationServiceInterface;

class StartsWithWAndEvenRecommendation implements RecommendationServiceInterface
{
    public function recomend(array $movies): array
    {
        return array_values(array_filter($movies, function ($movie) {
            return (strtoupper(substr($movie->getTitle(), 0, 1)) === 'W' && $movie->getTitleLength() % 2 === 0);
        }));
    }
}
