<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\Projection;

use App\Domain\ApplyMethodDispatcherTrait;
use App\Domain\Connoisseur\Event\ConnoisseurRegistered;
use App\Infrastructure\ReadModel\Repository\ConnoisseurViews;
use App\Infrastructure\ReadModel\View\ConnoisseurView;

final class ConnoisseurRegisteredProjector
{
    use ApplyMethodDispatcherTrait {
        applyMessage as public __invoke;
    }

    /** @var ConnoisseurViews */
    private $connoisseurViews;

    public function __construct(ConnoisseurViews $connoisseurViews)
    {
        $this->connoisseurViews = $connoisseurViews;
    }

    public function applyConnoisseurRegistered(ConnoisseurRegistered $connoisseurRegistered): void
    {
        $name = $connoisseurRegistered->name();
        $email = $connoisseurRegistered->email();
        $password = $connoisseurRegistered->password();

        $this->connoisseurViews->add(
            new ConnoisseurView(
                $name->value(),
                $email->value(),
                $password->value()
            )
        );
    }
}
