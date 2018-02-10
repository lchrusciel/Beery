<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Infrastructure\ReadModel\View\ConnoisseurView;
use App\Infrastructure\RecommendationEngine\RecommendationEngine;
use App\Infrastructure\RecommendationEngine\View\BeerView;
use App\Infrastructure\Repository\BeerViews;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final class RecommendBeersAction
{
    /** @var BeerViews */
    private $beerViews;

    /** @var SerializerInterface */
    private $serializer;

    /** @var RecommendationEngine */
    private $engine;

    public function __construct(BeerViews $beerViews, SerializerInterface $serializer, RecommendationEngine $engine)
    {
        $this->beerViews = $beerViews;
        $this->serializer = $serializer;
        $this->engine = $engine;
    }

    public function __invoke(Request $request, ConnoisseurView $connoisseur): Response
    {
        $recommendedBeers = $this->engine->getRecommendationFor($connoisseur->email());
        $recommendedBeersId = array_map(function (BeerView $beerView) {
            return $beerView->beerIdentifier();
        }, $recommendedBeers);

        $beers = $this->beerViews->getAllById($recommendedBeersId);

        return new JsonResponse($this->serializer->serialize($beers, 'json'), Response::HTTP_OK, [], true);
    }
}
