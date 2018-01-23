<?php

declare(strict_types=1);

namespace App\Domain\Connoisseur\Model;

use App\Domain\ApplyMethodDispatcherTrait;
use App\Domain\Connoisseur\Event\ConnoisseurRegistered;
use App\Domain\RecordsEvents;
use Prooph\EventSourcing\Aggregate\EventProducerTrait;

class Connoisseur implements RecordsEvents
{
    use EventProducerTrait;
    use ApplyMethodDispatcherTrait;

    /** @var Id */
    private $id;

    /** @var Name */
    private $name;

    /** @var Email */
    private $email;

    /** @var Password */
    private $password;

    private function __construct()
    {
    }

    public static function register(Id $id, Name $name, Email $email, Password $password): self
    {
        $connoisseur = new self();

        $connoisseur->recordThat(ConnoisseurRegistered::withData($id, $name, $email, $password));

        return $connoisseur;
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    protected function aggregateId(): string
    {
        return $this->id->value();
    }

    protected function applyConnoisseurRegistered(ConnoisseurRegistered $connoisseurRegistered): void
    {
        $this->id = $connoisseurRegistered->id();
        $this->name = $connoisseurRegistered->name();
        $this->email = $connoisseurRegistered->email();
        $this->password = $connoisseurRegistered->password();
    }
}
