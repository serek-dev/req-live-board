<?php

declare(strict_types=1);


namespace Acceptance;


use Scalo\Task\Game;
use Scalo\Task\ScoreBoard;
use Scalo\Task\ScoreBoardRepositoryInterface;
use Scalo\Task\Team;

final class HardcodedScoreBoardWithStartedGames implements ScoreBoardRepositoryInterface
{
    public const MEX_VS_CAN = '1';
    public const ESP_VS_BRA = '2';
    public const GER_VS_FRA = '3';
    public const URU_VS_ITA = '4';
    public const ARG_VS_AUT = '5';

    private ScoreBoard $cache;

    public function __construct()
    {
        $mexicoVsCanada = new Game(self::MEX_VS_CAN, new Team('mexico', 'Mexico'), new Team('canada', 'Canada'));
        $spainVsBrazil = new Game(self::ESP_VS_BRA, new Team('spain', 'Spain'), new Team('brazil', 'Brazil'));
        $germanyVsFrance = new Game(self::GER_VS_FRA, new Team('germany', 'Germany'), new Team('france', 'France'));
        $uruguayVsItaly = new Game(self::URU_VS_ITA, new Team('uruguay', 'Uruguay'), new Team('italy', 'Italy'));
        $argentinaVsAustralia = new Game(self::ARG_VS_AUT, new Team('argentina', 'Argentina'), new Team('australia', 'Australia'));

        $this->cache = new ScoreBoard(
            '2020-01-01.',
            $mexicoVsCanada->start(),
            $spainVsBrazil->start(),
            $germanyVsFrance->start(),
            $uruguayVsItaly->start(),
            $argentinaVsAustralia->start(),
        );;
    }

    public function getOne(/* string $id or $date */): ScoreBoard
    {
        return $this->cache;
    }

    public function store(ScoreBoard $board): void
    {
        // out of the scope
    }
}
