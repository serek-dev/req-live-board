<?php

declare(strict_types=1);


namespace Unit\Scalo\Task;


use PHPUnit\Framework\TestCase;
use Scalo\Task\DuplicateException;
use Scalo\Task\Game;
use Scalo\Task\RuntimeException;
use Scalo\Task\Score;
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

    public function testStartGame(): ScoreBoard
    {
        // Given I have my Football World Cup Live `ScoreBoard`
        $team1 = new Team(uniqid());
        $team2 = new Team(uniqid());
        $game1 = new Game('match-1', $team1, $team2);
        $sut = new ScoreBoard(uniqid(), $game1);

        // Then no `Games` should be on summary
        $this->assertEmpty($sut->getSummary());

        // When I start a concrete `Game`
        $sut->startGame('match-1');

        // Then a `Score` of this `Game` should be listed
        $this->assertCount(1, $sut->getSummary());

        return $sut;
    }

    /** @depends testStartGame */
    public function testChangeScoreOnStartedGame(ScoreBoard $sut): void
    {
        // Given I have already started `Game`

        // When I change the `Score`
        $sut->updateScore('match-1', new Score(1, 1));

        // Then a `Score` of this `Game` should contain a new value
        [$game] = $sut->getSummary();
        $this->assertEquals(new Score(1, 1), $game->getScore());
    }

    /** @depends testStartGame */
    public function testGameShouldNotAppearOnSummaryWhenItIsFinished(ScoreBoard $sut): void
    {
        // Given I have already started `Game`

        // When I finish it
        $sut->finish('match-1');

        // Then it should no longer be on the list
        $this->assertCount(0, $sut->getSummary());
    }

    public function testFailsWhenAttemptingToChangeScoreOnNonStartedGame(): void
    {
        // Given I have my Football World Cup Live `ScoreBoard`
        $team1 = new Team(uniqid());
        $team2 = new Team(uniqid());
        $game1 = new Game('match-1', $team1, $team2);
        $sut = new ScoreBoard(uniqid(), $game1);

        // Then I should see an error
        $this->expectException(RuntimeException::class);

        // When I change the `Score` of non-started `Game`
        $sut->updateScore('match-1', new Score(1, 1));
    }
}
