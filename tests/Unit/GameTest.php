<?php

namespace Unit\Scalo\Task;

use Scalo\Task\Game;
use PHPUnit\Framework\TestCase;

/** @covers \Scalo\Task\Game */
final class GameTest extends TestCase
{
    public function testConstructor(): void
    {
        // Given I have two `Teams`

        // And my scheduled `Game` for these teams

        // Then I should be able to create this object
    }

    public function testConstructorFailsOnDuplicatedTeams(): void
    {
        // Given I have one `Team`

        // And when I try to schedule a `Game` for the same team

        // Then I should se an error
    }

    public function testStartGame(): void
    {
        // Given I have two `Teams`

        // And my scheduled `Game` for these teams

        // When I start the `Game`

        // Then a `Score` should be "0:0"
    }
}
