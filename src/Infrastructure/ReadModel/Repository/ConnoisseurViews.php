<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\Repository;

use App\Infrastructure\ReadModel\View\ConnoisseurView;

interface ConnoisseurViews
{
    public function add(ConnoisseurView $connoisseurView): void;

    public function getByEmail(string $email): ConnoisseurView;
}
