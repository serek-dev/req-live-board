<?php

declare(strict_types=1);


namespace Scalo\Task;


use InvalidArgumentException;

final class Game
{
    private Score $score;
    private GameStatus $status;

    public function __construct(
        private readonly string $id,
        private readonly Team $homeTeam,
        private readonly Team $awayTeam,
    ) {
        if ($homeTeam->getId() === $awayTeam->getId()) {
            throw new InvalidArgumentException('Game can not be scheduled for the same team.');
        }
        $this->score = new Score(0, 0);

        $this->status = GameStatus::SCHEDULED;
    }

    public function getScore(): Score
    {
        return $this->score;
    }

    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function start(): void
    {
        $this->status = GameStatus::STARTED;
    }

    public function getStatus(): GameStatus
    {
        return $this->status;
    }
}
