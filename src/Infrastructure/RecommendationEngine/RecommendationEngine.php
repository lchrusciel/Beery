<?php

declare(strict_types=1);

namespace App\Infrastructure\RecommendationEngine;

use App\Infrastructure\RecommendationEngine\View\BeerView;

interface RecommendationEngine
{
    /**
     * @return array|BeerView[]
     */
    public function getRecommendationFor(string $connoisseur): array;
}
