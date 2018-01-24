<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\RegisterConnoisseur;
use App\Application\Repository\Connoisseurs;
use App\Domain\Connoisseur\Model\Connoisseur;

final class RegisterConnoisseurHandler
{
    /** @var Connoisseurs */
    private $connoisseurs;

    public function __construct(Connoisseurs $connoisseurs)
    {
        $this->connoisseurs = $connoisseurs;
    }

    public function __invoke(RegisterConnoisseur $registerConnoisseur): void
    {
        $connoisseur = Connoisseur::register(
            $registerConnoisseur->id(),
            $registerConnoisseur->name(),
            $registerConnoisseur->email(),
            $registerConnoisseur->password()
        );

        $this->connoisseurs->add($connoisseur);
    }
}
