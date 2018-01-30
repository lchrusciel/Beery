<?php

declare(strict_types=1);

namespace App\Infrastructure\RecommendationEngine\View;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Connoisseur")
 */
class ConnoisseurView
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
    private $email;

    /**
     * @var BeerRatingView[]|Collection
     *
     * @OGM\Relationship(relationshipEntity="BeerRatingView", type="RATED", direction="OUTGOING", collection=true, mappedBy="connoisseur")     *
     */
    private $ratedBeers;

    public function __construct(string $email)
    {
        $this->email = $email;
        $this->ratedBeers = new Collection();
    }
}
