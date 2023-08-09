<?php

declare(strict_types=1);


namespace Scalo\Task;

interface FacadeInterface
{
    /**
     * @return array<int, string>
     */
    public function getSummary(): array;

    public function changeScore(string $gameId, int $homeTeamScore, int $awayTeamScore): void;

    public function start(string $gameId): void;

    public function finish(string $gameId): void;
}
