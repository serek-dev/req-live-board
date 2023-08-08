<?php

declare(strict_types=1);


namespace Scalo\Task;


use InvalidArgumentException;
use Stringable;

final class Game implements Stringable
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

    // todo: probably better to handle projection in different layer
    public function __toString(): string
    {
        return sprintf(
            '%s %d - %s %d',
            $this->homeTeam->getName(),
            $this->score->getHomeTeam(),
            $this->awayTeam->getName(),
            $this->score->getAwayTeam(),
        );
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
