<?php

declare(strict_types=1);

namespace App\Infrastructure\Generator;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use Webmozart\Assert\Assert;

final class UuidOrderedTimeGenerator implements UuidGeneratorInterface
{
    /** @var UuidFactory */
    private $factory;

    public function __construct()
    {
        $this->initUuidFactory();

        $codec = new OrderedTimeCodec($this->factory->getUuidBuilder());

        $this->factory->setCodec($codec);
    }

    public function generate(): string
    {
        return (string) $this->factory->uuid1();
    }

    private function initUuidFactory(): void
    {
        /** @var UuidFactory $uuidFactory */
        $uuidFactory = clone Uuid::getFactory();

        Assert::isInstanceOf($uuidFactory, UuidFactory::class);

        $this->factory = $uuidFactory;
    }
}
