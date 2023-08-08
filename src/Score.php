<?php

declare(strict_types=1);


namespace Scalo\Task;


final class Score
{
    public function __construct(
        private readonly int $tomeTeam,
        private readonly int $awayTeam,
    )
    {
    }
}
