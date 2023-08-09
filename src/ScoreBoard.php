<?php

declare(strict_types=1);


namespace Scalo\Task;


use SplObjectStorage;

final class ScoreBoard
{
    /** @var SplObjectStorage<Game> */
    private SplObjectStorage $scheduledGames;

    public function __construct(
        private readonly string $id,
        Game ...$games
    ) {
        $this->scheduledGames = new SplObjectStorage();

        foreach ($games as $game) {
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
            $this->scheduledGames->attach($game);
        }
    }

    /** @return GameInterface[] */
    public function getSummary(): array
    {
        $onlyStarted = array_filter(iterator_to_array($this->scheduledGames), fn(GameInterface $g) => $g->getStatus() === GameStatus::STARTED);

        return array_values($onlyStarted);
    }

    /**
     * @throws RuntimeException
     * @throws NotFoundException
     */
    public function startGame(string $gameId): void
    {
        $game = $this->findGame($gameId, GameStatus::SCHEDULED);

        $game->start();
    }

    /**
     * @throws RuntimeException
     * @throws NotFoundException
     */
    public function updateScore(string $gameId, Score $score): void
    {
        $game = $this->findGame($gameId, GameStatus::STARTED);

        $game->changeScore($score);
    }

    /**
     * @throws RuntimeException
     * @throws NotFoundException
     */
    public function finish(string $gameId): void
    {
        $game = $this->findGame($gameId, GameStatus::STARTED);

        $game->finish();
    }

    /** @throws NotFoundException */
    private function findGame(string $gameId, GameStatus $status): Game
    {
        $game = array_filter($this->scheduledGames, fn(GameInterface $g) => $g->getId() === $gameId)[0] ?? null;

        if (empty($game)) {
            throw new NotFoundException(
                sprintf(
                    'Unable to find gameId: %s, has only: %s',
                    $gameId,
                    implode(', ', array_map(fn(GameInterface $game) => $game->getId(), iterator_to_array($this->scheduledGames))),
                )
            );
        }

        return $game;
    }
}
