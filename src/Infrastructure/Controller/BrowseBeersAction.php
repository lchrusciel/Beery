<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Infrastructure\Repository\BeerViews;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final class BrowseBeersAction
{
    /** @var BeerViews */
    private $beerViews;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(BeerViews $beerViews, SerializerInterface $serializer)
    {
        $this->beerViews = $beerViews;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request): Response
    {
        $beers = $this->serializer->serialize($this->beerViews->getAll(), 'json');

        return new JsonResponse($beers, Response::HTTP_OK, [], true);
    }
}
