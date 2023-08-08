<?php

namespace Unit\Scalo\Task;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Scalo\Task\Game;
use Scalo\Task\Team;

/** @covers \Scalo\Task\Game */
final class GameTest extends TestCase
{
    public function testConstructor(): void
    {
        // Given I have two `Teams`
        $team1 = new Team(uniqid());
        $team2 = new Team(uniqid());

        // And my scheduled `Game` for these teams
        $sut = new Game(uniqid(), $team1, $team2);

        // Then I should be able to create this object
        $this->assertInstanceOf(Game::class, $sut);
    }

    public function testConstructorFailsOnDuplicatedTeams(): void
    {
        // Given I have one `Team`
        $team1 = new Team(uniqid());

        // Then I should se an error
        $this->expectException(InvalidArgumentException::class);

        // And when I try to schedule a `Game` for the same team
        new Game(uniqid(), $team1, $team1);
    }

    public function testStartGame(): void
    {
        // Given I have two `Teams`

        // And my scheduled `Game` for these teams

        // When I start the `Game`

        // Then a `Score` should be "0:0"
    }
}
