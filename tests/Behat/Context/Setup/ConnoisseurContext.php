<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Setup;

use App\Application\Command\RegisterConnoisseur;
use App\Domain\Model\Email;
use App\Domain\Model\Id;
use App\Domain\Model\Name;
use App\Domain\Model\Password;
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
}
