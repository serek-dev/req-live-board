<?php

namespace Unit\Scalo\Task;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Scalo\Task\Game;
use Scalo\Task\GameStatus;
use Scalo\Task\Score;
use Scalo\Task\Team;

/** @covers \Scalo\Task\Game */
final class GameTest extends TestCase
{
    public function testConstructor(): Game
    {
        // Given I have two `Teams`
        $team1 = new Team(uniqid());
        $team2 = new Team(uniqid());

        // And my scheduled `Game` for these teams
        $sut = new Game(uniqid(), $team1, $team2);

        // Then I should be able to create this object
        $this->assertInstanceOf(Game::class, $sut);

        return $sut;
    }

    /** @depends testConstructor */
    public function testInitialScoreIs0To0(Game $sut): void
    {
        // Given I have a valid `Game`

        // Then initial `Score` should be 0:0
        $this->assertEquals(new Score(0, 0), $sut->getScore());
    }

    /** @depends testConstructor */
    public function testInitialStatusIsScheduled(Game $sut): void
    {
        $this->assertEquals(GameStatus::SCHEDULED, $sut->getStatus());
    }

    /** @depends testConstructor */
    public function testStartGame(Game $sut): void
    {
        // When I start `Game`
        $sut->start();

        // Then status should change
        $this->assertEquals(GameStatus::STARTED, $sut->getStatus());
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
}
