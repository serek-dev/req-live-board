<?php

namespace Unit\Scalo\Task;

use PHPUnit\Framework\TestCase;
use Scalo\Task\Team;

/** @covers \Scalo\Task\Team */
final class TeamTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $sut = new Team('1');
        $this->assertSame('1', $sut->getId());
    }
}
