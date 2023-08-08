<?php

declare(strict_types=1);


namespace Scalo\Task;


use InvalidArgumentException;

final class Score
{
    public function __construct(
        private readonly int $homeTeam,
        private readonly int $awayTeam,
    ) {
        if ($this->homeTeam < 0 || $this->awayTeam < 0) {
            throw new InvalidArgumentException('Score must be equal or greater than 0');
        }
    }

    public function getHomeTeam(): int
    {
        return $this->homeTeam;
    }

    public function getAwayTeam(): int
    {
        return $this->awayTeam;
    }
}
