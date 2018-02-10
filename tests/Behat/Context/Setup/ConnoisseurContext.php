<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Setup;

use App\Application\Command\RegisterConnoisseur;
use App\Domain\Connoisseur\Model\Email;
use App\Domain\Connoisseur\Model\Id;
use App\Domain\Connoisseur\Model\Name;
use App\Domain\Connoisseur\Model\Password;
use App\Infrastructure\Generator\UuidGeneratorInterface;
use App\Infrastructure\Security\ConnoisseurPasswordHasherInterface;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;

final class ConnoisseurContext implements Context
{
    /** @var CommandBus */
    private $commandBus;

    /** @var ConnoisseurPasswordHasherInterface */
    private $connoisseurPasswordHasher;

    /** @var UuidGeneratorInterface */
    private $uuidGenerator;

    public function __construct(
        CommandBus $commandBus,
        ConnoisseurPasswordHasherInterface $connoisseurPasswordHasher,
        UuidGeneratorInterface $uuidGenerator
    ) {
        $this->commandBus = $commandBus;
        $this->connoisseurPasswordHasher = $connoisseurPasswordHasher;
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * @Given I registered as :name with the :email email and the :password password
     */
    public function iRegisteredAsWithTheEmailAndThePassword(string $name, string $email, string $password): void
    {
        $this->commandBus->dispatch(RegisterConnoisseur::create(
            new Id($this->uuidGenerator->generate()),
            new Name($name),
            new Email($email),
            new Password(($this->connoisseurPasswordHasher)($password))
        ));
    }

    /**
     * @Given there is a :name connoisseur
     */
    public function thereIsAConnoisseur(string $name): void
    {
        $this->commandBus->dispatch(RegisterConnoisseur::create(
            new Id($this->uuidGenerator->generate()),
            new Name($name),
            new Email($this->generateEmail($name)),
            new Password(($this->connoisseurPasswordHasher)(str_shuffle($name)))
        ));
    }

    private function generateEmail(string $name): string
    {
        if (filter_var($name, FILTER_VALIDATE_EMAIL)) {
            return $name;
        }

        return str_replace(' ', '.', strtolower($name)) . '@example.com';
    }
}
