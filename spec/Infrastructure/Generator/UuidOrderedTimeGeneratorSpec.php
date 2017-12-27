<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\Generator;

use App\Infrastructure\Generator\UuidGeneratorInterface;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

final class UuidOrderedTimeGeneratorSpec extends ObjectBehavior
{
    function it_generates_valid_uuid(): void
    {
        $this->generate()->shouldReturnUuid();
    }

    function it_is_uuid_generator(): void
    {
        $this->shouldImplement(UuidGeneratorInterface::class);
    }

    public function getMatchers(): array
    {
        return [
            'returnUuid' => function ($subject): bool {
                return Uuid::isValid($subject);
            },
        ];
    }
}
