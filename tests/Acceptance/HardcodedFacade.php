<?php

declare(strict_types=1);


namespace Acceptance;


use Scalo\Task\FacadeInterface;
use Scalo\Task\RepositoryBasedPresenter;
use Scalo\Task\PresenterInterface;
use Scalo\Task\Score;
use Scalo\Task\ScoreBoardRepositoryInterface;

final class HardcodedFacade implements FacadeInterface
{
    private readonly PresenterInterface $presenter;
    private readonly ScoreBoardRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = new HardcodedScoreBoardWithStartedGames();
        $this->presenter = new RepositoryBasedPresenter($this->repository);
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
        // todo: eventually persist in the future
    }

    public function start(string $gameId): void
    {
        $board = $this->repository->getOne();
        $board->startGame($gameId);
        // todo: eventually persist in the future
    }

    public function finish(string $gameId): void
    {
        $board = $this->repository->getOne();
        $board->finish($gameId);
        // todo: eventually persist in the future
    }
}
