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
            $this->scheduledGames[$index] = $game;
        }
    }

    public function getSummary(): array
    {
        $onlyStarted = array_filter($this->scheduledGames, fn(Game $g) => $g->getStatus() === GameStatus::STARTED);

        return array_map(function (Game $game) {
            return (string)$game;
        }, $onlyStarted);
    }

    public function startGame(string $gameId): void
    {
        $game = array_filter($this->scheduledGames, fn(Game $g) => $g->getId() === $gameId)[0] ?? null;

        if (empty($game)) {
            throw new NotFoundException();
        }

        $game->start();
    }
}
