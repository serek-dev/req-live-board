<?php

declare(strict_types=1);


namespace Acceptance;


use Scalo\Task\Game;
use Scalo\Task\ScoreBoard;
use Scalo\Task\ScoreBoardRepositoryInterface;
use Scalo\Task\Team;

final class HardcodedScoreBoardWithStartedGames implements ScoreBoardRepositoryInterface
{
    private ScoreBoard $cache;

    public function __construct()
    {
        $mexicoVsCanada = new Game('1', new Team('mexico', 'Mexico'), new Team('canada', 'Canada'));
        $spainVsBrazil = new Game('2', new Team('spain', 'Spain'), new Team('brazil', 'Brazil'));
        $germanyVsFrance = new Game('3', new Team('germany', 'Germany'), new Team('france', 'France'));
        $uruguayVsItaly = new Game('4', new Team('uruguay', 'Uruguay'), new Team('italy', 'Italy'));
        $argentinaVsAustralia = new Game('5', new Team('argentina', 'Argentina'), new Team('australia', 'Australia'));

        $this->cache = new ScoreBoard(
            '2020-01-01.',
            $mexicoVsCanada->start(),
            $spainVsBrazil->start(),
            $germanyVsFrance->start(),
            $uruguayVsItaly->start(),
            $argentinaVsAustralia->start(),
        );;
    }

    public function getOne(): ScoreBoard
    {
        return $this->cache;
    }
}
