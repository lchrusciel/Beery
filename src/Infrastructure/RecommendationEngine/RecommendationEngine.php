<?php

declare(strict_types=1);

namespace App\Application\Recommendation;

use App\Domain\Connoisseur\Model\Connoisseur;
use App\Infrastructure\RecommendationEngine\View\BeerView;

interface RecommendationEngine
{
    /**
     * @return array|BeerView[]
     */
    public function getRecommendationFor(Connoisseur $connoisseur): array;
}
