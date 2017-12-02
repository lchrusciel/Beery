<?php

declare(strict_types=1);

namespace Tests\Service\Prooph\Plugin;

use Doctrine\Common\Collections\Collection;

interface EventsRecorder
{
    public function getLastMessage(): CollectedMessage;

    /**
     * @return Collection|CollectedMessage[]
     */
    public function getAllMessages(): Collection;
}
