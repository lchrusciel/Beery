<?php

declare(strict_types=1);

namespace App\Infrastructure\RecommendationEngine\View;

use GraphAware\Neo4j\OGM\Annotations as OGM;

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

    public function __construct(string $id, string $email)
    {
        $this->id = $id;
        $this->email = $email;
    }
}
