<?php

declare(strict_types=1);


namespace Scalo\Task;


final class Team
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
