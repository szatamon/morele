<?php

namespace App\Domain;

interface RecommendationServiceInterface
{
    public function recomend(array $movies): array;
}
