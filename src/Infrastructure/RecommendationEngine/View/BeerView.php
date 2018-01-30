<?php

declare(strict_types=1);

namespace App\Infrastructure\RecommendationEngine\View;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Beer")
 */
class BeerView
{
    /**
     * @var string
     *
     * @OGM\GraphId()
     */
    private $id;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    private $uuid;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    private $name;

    /**
     * @var BeerRatingView[]|Collection
     *
     * @OGM\Relationship(relationshipEntity="MovieRating", type="RATED", direction="INCOMING", collection=true, mappedBy="beer")
     */
    private $rates;

    public function __construct(string $id, string $name)
    {
        $this->uuid = $id;
        $this->name = $name;
        $this->rates = new Collection();
    }

    public function rate(BeerRatingView $beerRatingView): void
    {
        $this->rates->add($beerRatingView);
    }
}
