<?php

namespace Unit\Scalo\Task;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Scalo\Task\Score;

/** @covers \Scalo\Task\Score */
final class ScoreTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $sut = new Score(0, 1);
        $this->assertInstanceOf(Score::class, $sut);
        $this->assertSame(0, $sut->getHomeTeam());
        $this->assertSame(1, $sut->getAwayTeam());
    }

    /** @dataProvider providerForConstructorFailsOnNegativeNumbers */
    public function testConstructorFailsOnNegativeNumbers(int $home, int $away): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Score($home, $away);
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function providerForConstructorFailsOnNegativeNumbers(): array
    {
        return [
            'home team is negative' => [
                'home' => -1,
                'away' => 0,
            ],
            'away team is negative' => [
                'home' => 0,
                'away' => -1,
            ],
        ];
    }
}
