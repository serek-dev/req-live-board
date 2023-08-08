<?php

declare(strict_types=1);


namespace Scalo\Task;


enum GameStatus: string
{
    case SCHEDULED = 'scheduled';
    case STARTED = 'started';
    case FINISHED = 'finished';
}
