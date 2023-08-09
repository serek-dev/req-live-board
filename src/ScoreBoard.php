<?php

declare(strict_types=1);


namespace Scalo\Task;


final class ScoreBoard
{
    /** @var Game[] */
    private array $scheduledGames = [];

    public function __construct(
        private readonly string $id,
        Game ...$games
    ) {
        foreach ($games as $index => $game) {
            // Validate team was not yet scheduled for this Day
            foreach ($this->scheduledGames as $scheduledGame) {
                $existingTeams = [$scheduledGame->getHomeTeam()->getId(), $scheduledGame->getAwayTeam()->getId()];
                $error = new DuplicateException();

                if (in_array($game->getHomeTeam()->getId(), $existingTeams)) {
                    throw $error;
                }
                if (in_array($game->getAwayTeam()->getId(), $existingTeams)) {
                    throw $error;
                }
            }
            $this->scheduledGames[] = $game;
        }
    }

    /** @return Game[] */
    public function getSummary(): array
    {
        $onlyStarted = array_filter($this->scheduledGames, fn(Game $g) => $g->getStatus() === GameStatus::STARTED);

        return array_values($onlyStarted);
    }

    public function startGame(string $gameId): void
    {
        $game = array_filter($this->scheduledGames, fn(Game $g) => $g->getId() === $gameId)[0] ?? null;

        if (empty($game)) {
            throw new NotFoundException();
        }

        $game->start();
    }

    /** @throws RuntimeException */
    public function updateScore(string $gameId, Score $score): void
    {
        $game = array_filter($this->scheduledGames, fn(Game $g) => $g->getId() === $gameId)[0] ?? null;

        if (empty($game)) {
            throw new NotFoundException(
                sprintf(
                    'Unable to find gameId: %s, has only: %s',
                    $gameId,
                    implode(', ', array_map(fn(Game $game) => $game->getId(), $this->scheduledGames)),
                )
            );
        }

        $game->changeScore($score);
    }

    public function finish(string $gameId): void
    {
        $game = array_filter($this->scheduledGames, fn(Game $g) => $g->getId() === $gameId)[0] ?? null;

        if (empty($game)) {
            throw new NotFoundException(
                sprintf(
                    'Unable to find gameId: %s, has only: %s',
                    $gameId,
                    implode(', ', array_map(fn(Game $game) => $game->getId(), $this->scheduledGames)),
                )
            );
        }

        $game->finish();
    }
}
