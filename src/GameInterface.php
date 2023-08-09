<?php

namespace Scalo\Task;

interface GameInterface
{
    public function getScore(): Score;

    public function getHomeTeam(): Team;

    public function getAwayTeam(): Team;

    public function getId(): string;

    public function getStatus(): GameStatus;
}
