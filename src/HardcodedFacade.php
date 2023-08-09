<?php

declare(strict_types=1);


namespace Scalo\Task;


final class HardcodedFacade implements FacadeInterface
{
    /**
     * @return array<string, string>
     */
    public function getSummary(): array
    {
        return [];
    }

    public function changeScore(string $gameId, int $homeTeamScore, int $awayTeamScore): void
    {
    }

    public function start(string $gameId): void
    {
    }

    public function finish(string $gameId): void
    {
    }
}
