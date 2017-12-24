<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\Projection;

use App\Application\Event\ConnoisseurRegistered;
use App\Infrastructure\ReadModel\Repository\ConnoisseurViews;
use App\Infrastructure\ReadModel\View\ConnoisseurView;

final class ConnoisseurRegisteredProjector
{
    /** @var ConnoisseurViews */
    private $connoisseurViews;

    public function __construct(ConnoisseurViews $connoisseurViews)
    {
        $this->connoisseurViews = $connoisseurViews;
    }

    public function __invoke(ConnoisseurRegistered $connoisseurRegistered)
    {
        $this->connoisseurViews->add(
            new ConnoisseurView(
                $connoisseurRegistered->name()->value(),
                $connoisseurRegistered->email()->value(),
                $connoisseurRegistered->password()->value()
            )
        );
    }
}
