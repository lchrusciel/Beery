<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Setup;

use App\Application\Command\RegisterConnoisseur;
use App\Domain\Model\Email;
use App\Domain\Model\Name;
use App\Domain\Model\Password;
use App\Infrastructure\Security\ConnoisseurPasswordHasherInterface;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;

final class ConnoisseurContext implements Context
{
    /** @var CommandBus */
    private $commandBus;

    /** @var ConnoisseurPasswordHasherInterface */
    private $connoisseurPasswordHasher;

    public function __construct(CommandBus $commandBus, ConnoisseurPasswordHasherInterface $connoisseurPasswordHasher)
    {
        $this->commandBus = $commandBus;
        $this->connoisseurPasswordHasher = $connoisseurPasswordHasher;
    }

    /**
     * @Given I registered as :arg1 with the :arg2 email and the :arg3 password
     */
    public function iRegisteredAsWithTheEmailAndThePassword(string $name, string $email, string $password): void
    {
        $this->commandBus->dispatch(RegisterConnoisseur::create(
            new Name($name),
            new Email($email),
            new Password(($this->connoisseurPasswordHasher)($password))
        ));
    }
}
