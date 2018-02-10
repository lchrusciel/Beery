<?php

declare(strict_types=1);

namespace App\Infrastructure\RecommendationEngine\View;

use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 * @OGM\RelationshipEntity(type="RATED")
 */
class BeerRatingView
{
    /**
     * @var string
     *
     * @OGM\GraphId()
     */
    private $id;

    /**
     * @var ConnoisseurView
     *
     * @OGM\StartNode(targetEntity="ConnoisseurView")
     */
    private $connoisseur;

    /**
     * @var BeerView
     *
     * @OGM\EndNode(targetEntity="BeerView")
     */
    private $beer;

    /**
     * @var float
     *
     * @OGM\Property(type="float")
     */
    private $rate;

    public function __construct(ConnoisseurView $connoisseur, BeerView $beer, float $rate)
    {
        $this->connoisseur = $connoisseur;
        $this->beer = $beer;
        $this->rate = $rate;
    }
}
