<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\RegisterConnoisseur;
use App\Application\Event\ConnoisseurRegistered;
use App\Application\Repository\Connoisseurs;
use App\Domain\Model\Connoisseur;
use Prooph\ServiceBus\EventBus;

final class RegisterConnoisseurHandler
{
    /** @var EventBus */
    private $eventBus;

    /** @var Connoisseurs */
    private $connoisseurs;

    public function __construct(EventBus $eventBus, Connoisseurs $connoisseurs)
    {
        $this->eventBus = $eventBus;
        $this->connoisseurs = $connoisseurs;
    }

    public function __invoke(RegisterConnoisseur $registerConnoisseur): void
    {
        $connoisseur = Connoisseur::register(
            $registerConnoisseur->name(),
            $registerConnoisseur->email(),
            $registerConnoisseur->password()
        );

        $this->connoisseurs->add($connoisseur);

        $this->eventBus->dispatch(ConnoisseurRegistered::occur(
            $registerConnoisseur->name(),
            $registerConnoisseur->email(),
            $registerConnoisseur->password()
        ));
    }
}
