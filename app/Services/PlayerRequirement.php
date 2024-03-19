<?php


namespace App\Services;

use App\Contracts\PlayersSelectionStrategy;

class PlayerRequirement
{
    public $positionArray;
    public $positionSkillArray;
    public $strategy;
    public $requirement;

    public function __construct($positionArray, $positionSkillArray, PlayersSelectionStrategy $strategy,  $requirement)
    {
        $this->positionArray = $positionArray;
        $this->positionSkillArray = $positionSkillArray;
        $this->strategy = $strategy;
        $this->requirement = $requirement;
    }
}
