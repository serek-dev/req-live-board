<?php

declare(strict_types=1);


namespace Scalo\Task;

interface PresenterInterface
{
    /**
     * @return array<int, string>
     */
    public function getSummary(): array;
}
