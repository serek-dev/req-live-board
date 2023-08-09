<?php

declare(strict_types=1);


namespace Scalo\Task;


final class RepositoryBasedPresenter implements PresenterInterface
{
    public function __construct(private readonly ScoreBoardRepositoryInterface $scoreBoardRepository)
    {
    }

    /**
     * @return array<int, string>
     */
    public function getSummary(): array
    {
        $games = $this->scoreBoardRepository->getOne(/* string $id or $date */)->getSummary();

        // Order by sum score
        usort($games, function (GameInterface $a, GameInterface $b) {
            $sumA = $a->getScore()->getHomeTeam() + $a->getScore()->getAwayTeam();
            $sumB = $b->getScore()->getHomeTeam() + $b->getScore()->getAwayTeam();

            if ($sumA == $sumB) {
                // If sums are equal, compare based on the original index
                return 0;
            }

            return ($sumA < $sumB) ? 1 : -1;
        });

        return array_values(
            array_map(function (GameInterface $g): string {
                $home = $g->getHomeTeam();
                $away = $g->getAwayTeam();
                return sprintf('%s %d - %s %d', $home->getName(), $g->getScore()->getHomeTeam(), $away->getName(), $g->getScore()->getAwayTeam());
            }, $games)
        );
    }
}
