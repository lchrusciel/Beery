<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Infrastructure\View\ConnoisseurView;

interface ConnoisseurViews
{
    public function add(ConnoisseurView $connoisseurView): void;

    public function getByEmail(string $email): ConnoisseurView;
}
