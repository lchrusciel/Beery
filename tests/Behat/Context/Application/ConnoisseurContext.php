<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Application;

use App\Application\Command\RegisterConnoisseur;
use App\Application\Event\ConnoisseurRegistered;
use App\Domain\Connoisseur\Model\Email;
use App\Domain\Connoisseur\Model\Id;
use App\Domain\Connoisseur\Model\Name;
use App\Domain\Connoisseur\Model\Password;
use App\Infrastructure\Generator\UuidGeneratorInterface;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;
use Tests\Service\Prooph\Plugin\EventsRecorder;
use Webmozart\Assert\Assert;

final class ConnoisseurContext implements Context
{
    /** @var CommandBus */
    private $commandBus;

    /** @var EventsRecorder */
    private $eventsRecorder;

    /** @var UuidGeneratorInterface */
    private $uuidGenerator;

    public function __construct(
        CommandBus $commandBus,
        EventsRecorder $eventsRecorder,
        UuidGeneratorInterface $uuidGenerator
    ) {
        $this->commandBus = $commandBus;
        $this->eventsRecorder = $eventsRecorder;
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * @When I register the :name connoisseur with the :email email and the :password password
     */
    public function iRegisterTheConnoisseurWithTheEmailAndTheEmail(string $name, string $email, string $password): void
    {
        $this->commandBus->dispatch(RegisterConnoisseur::create(
            new Id($this->uuidGenerator->generate()),
            new Name($name),
            new Email($email),
            new Password(password_hash($password, PASSWORD_BCRYPT))
        ));
    }

    /**
     * @Then I should be able to log in as :email with :password password
     */
    public function theConnoisseurShouldBeCreated(string $email, string $password): void
    {
        $message = $this->eventsRecorder->getLastMessage();

        $event = $message->event();
        \assert($event instanceof ConnoisseurRegistered);
        Assert::eq($event->email(), new Email($email));
    }
}
