<?php

declare(strict_types=1);


namespace Scalo\Task;


use InvalidArgumentException;

final class Game implements GameInterface
{
    private Score $score;
    private GameStatus $status;
    private int $order;

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

    public function start(): self
    {
        $this->status = GameStatus::STARTED;
        return $this;
    }

    public function finish(): void
    {
        $this->status = GameStatus::FINISHED;
    }

    public function getStatus(): GameStatus
    {
        return $this->status;
    }

    /**
     * @throws RuntimeException
     */
    public function changeScore(Score $score): self
    {
        if ($this->status !== GameStatus::STARTED) {
            throw new RuntimeException(
                'To change the score, Game must be running'
            );
        }
        $this->score = $score;

        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $value): void
    {
        $this->order = $value;
    }
}
