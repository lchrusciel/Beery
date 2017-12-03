<?php

declare(strict_types=1);

namespace spec\App\Domain\Model;

use App\Domain\Model\Connoisseur;
use App\Domain\Model\Email;
use App\Domain\Model\Name;
use App\Domain\Model\Password;
use PhpSpec\ObjectBehavior;

final class ConnoisseurSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('register', [
            new Name('Krzystof Krawczyk'),
            new Email('krawczyk@biale.pl'),
            new Password('parostatkiem1'),
        ]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Connoisseur::class);
    }
}
