<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Infrastructure\ReadModel\View\BeerView;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final class BrowseBeersAction
{
    /** @var ObjectRepository */
    private $repository;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(ObjectManager $objectManager, SerializerInterface $serializer)
    {
        $this->repository = $objectManager->getRepository(BeerView::class);
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request): Response
    {
        $beers = $this->serializer->serialize($this->repository->findAll(), 'json');

        return new JsonResponse($beers, Response::HTTP_OK, [], true);
    }
}
