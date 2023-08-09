<?php

declare(strict_types=1);


namespace Scalo\Task;

interface ScoreBoardRepositoryInterface
{
    /** @throws NotFoundException */
    public function getOne(/* string $id or $date */): ScoreBoard;

    public function store(ScoreBoard $board): void;
}
