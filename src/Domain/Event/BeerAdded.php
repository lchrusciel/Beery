<?php

declare(strict_types=1);

namespace App\Domain\Event;

final class BeerAdded
{
    /** @var string */
    private $name;

    /** @var int */
    private $abv;

    private function __construct(string $name, int $abv)
    {
        $this->name = $name;
        $this->abv = $abv;
    }

    public static function occur(string $name, int $abv)
    {
        return new BeerAdded($name, $abv);
    }

    public function name()
    {
        return $this->name;
    }

    public function abv()
    {
        return $this->abv;
    }
}
