<?php

declare(strict_types=1);


namespace Unit\Scalo\Task;


use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Scalo\Task\DuplicateException;
use Scalo\Task\Game;
use Scalo\Task\ScoreBoard;
use Scalo\Task\Team;

/** @covers \Scalo\Task\ScoreBoard */
final class ScoreBoardTest extends TestCase
{
    public function testScoreBoardConstruction(): void
    {
        // Given I have my Football World Cup Live `ScoreBoard`
        // With scheduled some `Games` across unique `Team` pairs
        $sut = new ScoreBoard(uniqid());
        $this->assertInstanceOf(ScoreBoard::class, $sut);
    }

    public function testScoreBoardConstructionFailsOnDuplicatedTeams(): void
    {
        // Given `Teams`
        $team1 = new Team(uniqid());
        $team2 = new Team(uniqid());
        $team3 = new Team(uniqid());

        // When any team is scheduled for more than one `Game` within `ScoreBoard` `Day`
        $game1 = new Game(uniqid(), $team1, $team2);
        $game2 = new Game(uniqid(), $team3, $team1);

        // I should not be able to broadcast `Scores` and see error
        $this->expectException(DuplicateException::class);
        new ScoreBoard(uniqid(), $game1, $game2);
    }

    public function testStartGame(): void
    {
        // Given I have my Football World Cup Live `ScoreBoard`

        // When I start a concrete `Game`

        // Then a `Score` of this `Game` should be listed with 0:0
    }

    public function testChangeScoreOnStartGame(): void
    {
        // Given I have my Football World Cup Live `ScoreBoard`

        // When I start a concrete `Game`

        // And I change the `Score` of concrete `Game`

        // Then a `Score` of this `Game` should contain a new value

        // And the order should change
    }

    public function testFailsWhenAttemptingToChangeScoreOnNonStartedGame(): void
    {
        // Given I have my Football World Cup Live `ScoreBoard`

        // Then I should see an error

        // When I change the `Score` of non-started `Game`
    }
}
