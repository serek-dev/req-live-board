<?php

declare(strict_types=1);


namespace Scalo\Task;


use InvalidArgumentException;

final class Game
{
    public function __construct(
        private readonly string $id,
        private readonly Team $homeTeam,
        private readonly Team $awayTeam,
    ) {
        if ($homeTeam->getId() === $awayTeam->getId()) {
            throw new InvalidArgumentException('Game can not be scheduled for the same team.');
        }
    }
}
