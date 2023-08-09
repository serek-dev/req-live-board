<?php

namespace Acceptance;

use PHPUnit\Framework\TestCase;
use Scalo\Task\FacadeInterface;


/**
 * Background:
 * We have an existing "Football World Cup"
 * And we have scheduled matches for many days
 * Here we are acting in the scope of one day = 2020-01-01 as an example
 *
 * And the following `Games` are started:
 * 'Mexico 0 - Canada 0',
 * 'Spain 0 - Brazil 0',
 * 'Germany 0 - France 0',
 * 'Uruguay 0 - Italy 0',
 * 'Argentina 0 - Australia 0',
 */
final class AcceptanceTest extends TestCase
{
    /*
     * Start a game. When a game starts, it should capture (being initial score 0-0)
     */
    public function testICanSeeLiveSummaryOfGamesWith0To0ScoreOnStartedMatches(): void
    {
        // As the module user of `Broadcasting Service`

        // When I see visit a website
        $facade = new HardcodedFacade();

        // I want to see all live results with 0:0 score
        // And ordered from the latest added (Argentina is last entry)

        $summary = $facade->getSummary();

        $this->assertEquals([
            'Argentina 0 - Australia 0',
            'Uruguay 0 - Italy 0',
            'Germany 0 - France 0',
            'Spain 0 - Brazil 0',
            'Mexico 0 - Canada 0',
        ], $summary);
    }

    public function testICanSeeLiveSummaryOfGamesOrderedCorrectlyWhenScoresChanges(): void
    {
        // As the module user of `Broadcasting Service`

        // When I see visit a website
        $facade = new HardcodedFacade();

        /*
         As an example, being the current data in the system:
         */
        $facade->changeScore(HardcodedScoreBoardWithStartedGames::MEX_VS_CAN, 0, 5);
        $facade->changeScore(HardcodedScoreBoardWithStartedGames::ESP_VS_BRA, 10, 2);
        $facade->changeScore(HardcodedScoreBoardWithStartedGames::GER_VS_FRA, 2, 2);
        $facade->changeScore(HardcodedScoreBoardWithStartedGames::URU_VS_ITA, 6, 6);
        $facade->changeScore(HardcodedScoreBoardWithStartedGames::ARG_VS_AUT, 3, 1);

        // I want to see all live results
        // Ordered by sum of home & away teams `Score`
        // When `Score` is equal
        // Then it should be ordered by latest added `Game`

        $summary = $facade->getSummary();

        /*
         The summary would provide with the following information:
         */

        // URU was added later so has precedence

        $this->assertEquals([
            'Uruguay 6 - Italy 6', # 12
            'Spain 10 - Brazil 2', # 12
            'Mexico 0 - Canada 5', # 5
            'Argentina 3 - Australia 1', # 4
            'Germany 2 - France 2', # 4
        ], $summary);
    }

    /*
     * Update score. Receiving the pair score; home team score and away team score updates a game score
     */
    public function testICanSeeLiveSummaryOfGameScoreUpdates(): FacadeInterface
    {
        // As the module user of `Broadcasting Service`

        // When I see visit a website
        $facade = new HardcodedFacade();

        // I want to see all live results

        // Ordered correctly

        // When `Score` changed
        $facade->changeScore(HardcodedScoreBoardWithStartedGames::ESP_VS_BRA, 0, 2);

        // Then summary should be affected and `Score`

        $summary = $facade->getSummary();

        $this->assertEquals([
            'Spain 0 - Brazil 2',
            'Argentina 0 - Australia 0',
            'Uruguay 0 - Italy 0',
            'Germany 0 - France 0',
            'Mexico 0 - Canada 0',
        ], $summary);

        return $facade;
    }

    /** @depends testICanSeeLiveSummaryOfGameScoreUpdates */
    public function testICanSeeLiveSummaryOfGamesWhenScoreIsGameSoOrderOfSchedulingShouldHavePrecedence(FacadeInterface $facade): FacadeInterface
    {
        // When Mexico vs Canada Score is the same
        $facade->changeScore(HardcodedScoreBoardWithStartedGames::MEX_VS_CAN, 0, 2);

        // Then it should be at the top

        $summary = $facade->getSummary();
        $this->assertEquals([
            'Spain 0 - Brazil 2',
            'Mexico 0 - Canada 2',
            'Argentina 0 - Australia 0',
            'Uruguay 0 - Italy 0',
            'Germany 0 - France 0',
        ], $summary);

        return $facade;
    }

    /*
     * Finish a game. It will remove a match from the scoreboard.
     */
    /** @depends testICanSeeLiveSummaryOfGamesWhenScoreIsGameSoOrderOfSchedulingShouldHavePrecedence */
    public function testICanSeeLiveSummaryOfGamesButNoFinishedMatchesShouldBeThere(FacadeInterface $facade): void
    {
        // As the module user of `Broadcasting Service`

        // When one `Game` is finished
        $facade->finish(HardcodedScoreBoardWithStartedGames::ESP_VS_BRA);

        // Then it should not be listed anymore
        foreach ($facade->getSummary() as $view) {
            $this->assertStringNotContainsString('Spain', $view);
        }
    }
}
