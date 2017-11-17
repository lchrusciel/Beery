<?php

declare(strict_types=1);

namespace App\Infrastructure\View;

final class BeerView
{
    /** @var string */
    private $title;

    /** @var int */
    private $abv;

    public function __construct(string $title, int $abv)
    {
        $this->title = $title;
        $this->abv = $abv;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function abv(): int
    {
        return $this->abv;
    }
}
