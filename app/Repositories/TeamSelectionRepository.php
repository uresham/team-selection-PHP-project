<?php

namespace App\Repositories;

use App\Models\Player;
use App\Models\PlayerSkill;

class TeamSelectionRepository
{
    public function findByPositionAndSkill($position, $skill, $order='desc'):array
    {

        try {
            return Player::where('position', $position)
                        ->whereHas('skills', function ($query) use ($skill) {
                            $query->where('skill', $skill);
                        })
                        ->orderBy(PlayerSkill::select('value')
                        ->where('skill', $skill)->whereColumn('player_id', 'players.id'), $order)
                        ->select('players.*')
                        ->with('skills')
                        ->get()->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
        
    }


    public function findByPosition($position):array
    {
        try {
            return Player::where('position', $position)->get()->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
