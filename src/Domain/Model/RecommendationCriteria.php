<?php

namespace App\Domain\Model;

enum RecommendationCriteria: string
{
    case RANDOM = 'random';
    case STARTS_WITH_W_AND_EVEN = 'starts_with_w_and_even';
    case MULTI_WORD_TITLES = 'multi_word_titles';


    public static function fromString(string $value): ?self
    {
        $normalizedValue = strtolower(str_replace(' ', '_', $value));

        return self::tryFrom($normalizedValue);
    }
}
