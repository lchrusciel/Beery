<?php

declare(strict_types=1);

namespace App\Application\Repository\Exception;

use Zend\EventManager\Exception\DomainException;

final class BeerNotFoundException extends DomainException
{
}
