<?php

declare(strict_types=1);


namespace Unit\Scalo\Task;


use PHPUnit\Framework\TestCase;

/** @covers \Scalo\Task\ScoreBoard */
final class ScoreBoardTest extends TestCase
{
    public function testScoreBoardConstruction(): void
    {
        // Given I have my Football World Cup Live `ScoreBoard`

        // And I have scheduled some `Games` across unique `Team` pairs
    }

    public function testScoreBoardConstructionFailsOnDuplicatedTeams(): void
    {
        // I should not be able to broadcast `Scores`

        // When any team is scheduled for more than one `Game` within `ScoreBoard` `Day`
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
