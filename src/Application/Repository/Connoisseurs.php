<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Domain\Connoisseur\Model\Connoisseur;

interface Connoisseurs
{
    public function add(Connoisseur $connoisseur): void;

    public function getOneByEmail(string $email): Connoisseur;

    public function getOneByName(string $connoisseurName): Connoisseur;
}
