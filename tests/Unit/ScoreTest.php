<?php

namespace Unit\Scalo\Task;

use Scalo\Task\Score;
use PHPUnit\Framework\TestCase;

/** @covers \Scalo\Task\Score */
final class ScoreTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Score(0, 0);
        $this->assertInstanceOf(Score::class, $sut);
    }
}
