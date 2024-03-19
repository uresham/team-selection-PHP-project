<?php

namespace App\Transformers;


class PlayerTransformer extends Transformer
{
    public function transform($player, array $options=[])
    {
        return [
            'id' => $player['id'],
            'name' => $player['name'],
            'position' => $player['position'],
            'playerSkills' => array_map(function ($skill) {
                return [
                    'id' => $skill['id'],
                    'skill' => $skill['skill'],
                    'value' => $skill['value'],
                    'playerId' => $skill['player_id']
                ];
    
            }, $player['skills'])
        ];
    }
}