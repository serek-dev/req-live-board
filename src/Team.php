<?php

declare(strict_types=1);


namespace Scalo\Task;


final class Team
{
    public function __construct(private readonly string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
