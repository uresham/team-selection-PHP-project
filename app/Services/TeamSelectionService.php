<?php


namespace App\Services;

use App\Contracts\TeamSelectionStrategy;

class TeamSelectionService
{
    private $teamSelectionStrategy;

    public function __construct(TeamSelectionStrategy $teamSelectionStrategy)
    {
        $this->teamSelectionStrategy = $teamSelectionStrategy;
    }

    public function selectTeam($requirements)
    {
        return $this->teamSelectionStrategy->selectTeam($requirements);
    }
}
