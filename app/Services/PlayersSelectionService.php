<?php

namespace App\Services;

use App\Contracts\PlayersSelectionStrategy;

class PlayersSelectionService
{
    private $playersSelectionStrategy;

    public function __construct(PlayersSelectionStrategy $playersSelectionStrategy)
    {
        $this->playersSelectionStrategy = $playersSelectionStrategy;
    }

    public function selectPlayers(...$requirements)
    {
        return $this->playersSelectionStrategy->selectPlayers(...$requirements);
    }
}
