<?php

declare(strict_types=1);

namespace App\Domain\Beer\Model;

use App\Domain\ApplyMethodDispatcherTrait;
use App\Domain\Beer\Event\BeerAdded;
use App\Domain\Beer\Event\BeerRated;
use App\Domain\Connoisseur\Model\Email;
use App\Domain\RecordsEvents;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Prooph\EventSourcing\Aggregate\EventProducerTrait;

class Beer implements RecordsEvents
{
    use EventProducerTrait;
    use ApplyMethodDispatcherTrait;

    /** @var Id */
    private $id;

    /** @var Name */
    private $name;

    /** @var Abv */
    private $abv;

    /** @var Collection */
    private $rates;

    public static function add(Id $id, Name $name, Abv $abv): self
    {
        $beer = new self();

        $beer->recordThat(BeerAdded::withData($id, $name, $abv));

        return $beer;
    }

    public function id(): Id
    {
        return $this->id;
    }

    protected function aggregateId(): string
    {
        return $this->id()->value();
    }

    public function rate(Email $email, Rate $rate): void
    {
        $this->recordThat(BeerRated::withData($this->id(), $email, $rate));
    }

    protected function applyBeerAdded(BeerAdded $event): void
    {
        $this->id = $event->id();
        $this->name = $event->name();
        $this->abv = $event->abv();
        $this->rates = new ArrayCollection();
    }

    protected function applyBeerRated(BeerRated $event): void
    {
        $this->rates->add($event->rate());
    }
}
