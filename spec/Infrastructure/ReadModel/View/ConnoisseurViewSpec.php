<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\ReadModel\View;

use PhpSpec\ObjectBehavior;

final class ConnoisseurViewSpec extends ObjectBehavior
{
    function it_a_connoisseur_projection(): void
    {
        $this->beConstructedWith(
            'Krzysztof Krawczyk',
            'krzysztof@biale.pl',
            '$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua'
        );

        $this->name()->shouldReturn('Krzysztof Krawczyk');
        $this->email()->shouldReturn('krzysztof@biale.pl');
        $this->password()->shouldReturn('$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua');
    }
}
