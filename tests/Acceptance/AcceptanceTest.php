<?php

namespace Acceptance\Scalo;

use PHPUnit\Framework\TestCase;


final class AcceptanceTest extends TestCase
{
    /*
     * Start a game. When a game starts, it should capture (being initial score 0-0)
     */
    public function testICanSeeLiveSummaryOfGames(): void
    {
        // As the module user of `Broadcasting Service`

        // When I see visit a website

        // I want to see all live results

        // Ordered by sum of home & away teams `Score`

        // When `Score` is equal

        // Then it should be ordered by adding order
    }

    /*
     * Update score. Receiving the pair score; home team score and away team score updates a game score
     */
    public function testICanSeeLiveSummaryOfGameScoreUpdates(): void
    {
        // As the module user of `Broadcasting Service`

        // When I see visit a website

        // I want to see all live results

        // Ordered correctly

        // When `Score` changed

        // Then summary should be affected and `Score`
    }

    /*
     * Finish a game. It will remove a match from the scoreboard.
     */
    public function testICanNotSeeFinishedGames(): void
    {
        // As the module user of `Broadcasting Service`

        // When I see visit a website

        // I want to see all live results

        // And when one `Game` finished

        // Then it should not be listed anymore
    }
}
