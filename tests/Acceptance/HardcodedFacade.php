<?php

declare(strict_types=1);


namespace Acceptance;


use Scalo\Task\FacadeInterface;
use Scalo\Task\Score;
use Scalo\Task\ScoreBoardRepositoryInterface;

final class HardcodedFacade implements FacadeInterface
{
    private HardcodedPresenter $presenter;

    public function __construct(private readonly ?ScoreBoardRepositoryInterface $repository = new HardcodedScoreBoardWithStartedGames())
    {
        $this->presenter = new HardcodedPresenter(
            $this->repository
        );
    }

    /**
     * @return array<string, string>
     */
    public function getSummary(): array
    {
        return $this->presenter->getSummary();
    }

    public function changeScore(string $gameId, int $homeTeamScore, int $awayTeamScore): void
    {
        $board = $this->repository->getOne();
        $board->updateScore($gameId, new Score($homeTeamScore, $awayTeamScore));
    }

    public function start(string $gameId): void
    {
    }

    public function finish(string $gameId): void
    {
    }
}
