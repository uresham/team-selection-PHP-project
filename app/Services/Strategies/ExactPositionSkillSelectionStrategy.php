<?php

namespace App\Services\Strategies;

use App\Contracts\PlayersSelectionStrategy;

class ExactPositionSkillSelectionStrategy  implements PlayersSelectionStrategy
{
    public function selectPlayers($positionArray, $positionSkillArray, array $requirement): array
    {
        try {
            return array_slice(
                $positionSkillArray, 0, $requirement['numberOfPlayers']
            );
        } catch (\Exception $e) {
            throw $e;
        }
        
    }
}
