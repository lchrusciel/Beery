<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Application;

use App\Application\Command\RegisterConnoisseur;
use App\Application\Event\ConnoisseurRegistered;
use App\Domain\Model\Email;
use App\Domain\Model\Name;
use App\Domain\Model\Password;
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

    public function __construct(CommandBus $commandBus, EventsRecorder $eventsRecorder)
    {
        $this->commandBus = $commandBus;
        $this->eventsRecorder = $eventsRecorder;
    }

    /**
     * @When I register the :name connoisseur with the :email email and the :passoword email
     */
    public function iRegisterTheConnoisseurWithTheEmailAndTheEmail(string $name, string $email, string $passoword): void
    {
        $this->commandBus->dispatch(RegisterConnoisseur::create(new Name($name), new Email($email), new Password($passoword)));
    }

    /**
     * @Then the :name connoisseur should be created
     */
    public function theConnoisseurShouldBeCreated(string $name): void
    {
        $message = $this->eventsRecorder->getLastMessage();

        $event = $message->event();
        \assert($event instanceof ConnoisseurRegistered);
        Assert::eq($event->name(), new Name($name));
    }
}
