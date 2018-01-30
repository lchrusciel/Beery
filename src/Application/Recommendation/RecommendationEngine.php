<?php

declare(strict_types=1);

namespace App\Application\Recommendation;

use App\Domain\Beer\Model\Id;
use App\Domain\Connoisseur\Model\Connoisseur;

interface RecommendationEngine
{
    /**
     * @return array|Id[]
     */
    public function getRecommendationFor(Connoisseur $connoisseur): array;
}
