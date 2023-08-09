<?php

declare(strict_types=1);


namespace Scalo\Task;


final class Facade implements FacadeInterface
{
    public function __construct(
        private readonly ScoreBoardRepositoryInterface $repository,
        private readonly PresenterInterface $presenter,
    ) {
    }

    /** @inheritdoc */
    public function getSummary(): array
    {
        return $this->presenter->getSummary();
    }

    public function changeScore(string $gameId, int $homeTeamScore, int $awayTeamScore): void
    {
        $board = $this->repository->getOne();
        $board->updateScore($gameId, new Score($homeTeamScore, $awayTeamScore));
        $this->repository->store($board);
    }

    public function start(string $gameId): void
    {
        $board = $this->repository->getOne();
        $board->startGame($gameId);
        $this->repository->store($board);
    }

    public function finish(string $gameId): void
    {
        $board = $this->repository->getOne();
        $board->finish($gameId);
        $this->repository->store($board);
    }
}
