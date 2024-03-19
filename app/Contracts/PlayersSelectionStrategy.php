<?php


namespace App\Contracts;

interface PlayersSelectionStrategy
{
    public function selectPlayers($positionArray, $positionSkillArray, array $requirement): array;
}
