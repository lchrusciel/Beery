<?php

declare(strict_types=1);

namespace spec\App\Domain\Model;

use App\Domain\Model\Rate;
use App\Domain\Model\Rates;
use PhpSpec\ObjectBehavior;

final class RatesSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Rates::class);
    }

    function it_contains_rates(): void
    {
        $this->add(new Rate(3.5));
    }
}
