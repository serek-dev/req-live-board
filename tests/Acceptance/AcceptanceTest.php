<?php

namespace Acceptance;

use PHPUnit\Framework\TestCase;


/**
 * Background:
 * We have an existing "Football World Cup"
 * And we have scheduled matches for many days
 * Here we are acting in the scope of one day = 2020-01-01.
 */
final class AcceptanceTest extends TestCase
{
    /*
     * Start a game. When a game starts, it should capture (being initial score 0-0)
     */
    public function testICanSeeLiveSummaryOfGames(): void
    {
        // As the module user of `Broadcasting Service`

        // When I see visit a website
        $facade = new HardcodedFacade();

        // I want to see all live results with 0:0 score
        // And ordered chronically

        $summary = $facade->getSummary();

        $this->assertEquals([
            'Mexico 0 - Canada 0',
            'Spain 0 - Brazil 0',
            'Germany 0 - France 0',
            'Uruguay 0 - Italy 0',
            'Argentina 0 - Australia 0',
        ], $summary);
    }
//
//    public function testICanSeeLiveSummaryOfGamesOrdered(): void
//    {
//        // As the module user of `Broadcasting Service`
//
//        // When I see visit a website
//        $facade = new HardcodedFacade();
//
//        // I want to see all live results
//        // Ordered by sum of home & away teams `Score`
//        // When `Score` is equal
//        // Then it should be ordered by adding order
//
//        $summary = $facade->getSummary();
//        $this->assertEquals([
//            'Uruguay 0 - Italy 0',
//            'Spain 0 - Brazil 0',
//            'Mexico 0 - Canada 0',
//            'Argentina 0 - Australia 0',
//            'Germany 0 - France 0',
//        ], $summary);
//    }
//
    /*
     * Update score. Receiving the pair score; home team score and away team score updates a game score
     */
    public function testICanSeeLiveSummaryOfGameScoreUpdates(): void
    {
        // As the module user of `Broadcasting Service`

        // When I see visit a website
        $facade = new HardcodedFacade();

        // I want to see all live results

        // Ordered correctly

        // When `Score` changed
        $facade->changeScore('2', 0, 2);

        // Then summary should be affected and `Score`

        $summary = $facade->getSummary();

        $this->assertEquals([
            'Spain 0 - Brazil 2',
            'Mexico 0 - Canada 0',
            'Germany 0 - France 0',
            'Uruguay 0 - Italy 0',
            'Argentina 0 - Australia 0',
        ], $summary);
    }
//
//    /*
//     * Finish a game. It will remove a match from the scoreboard.
//     */
//    public function testICanNotSeeFinishedGames(): void
//    {
//        // As the module user of `Broadcasting Service`
//
//        // When I see visit a website
//
//        // I want to see all live results
//
//        // And when one `Game` finished
//
//        // Then it should not be listed anymore
//    }
}
