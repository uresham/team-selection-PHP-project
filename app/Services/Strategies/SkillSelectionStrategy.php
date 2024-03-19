<?php

namespace App\Services\Strategies;

use App\Contracts\PlayersSelectionStrategy;

class SkillSelectionStrategy  implements PlayersSelectionStrategy
{

    public function selectPlayers($positionArray, $positionSkillArray, array $requirement): array
    {
        try {
            $extraPlayersCount = $requirement['numberOfPlayers'] - count($positionSkillArray);
            $extraPlayers = $this->choosePlayersBySkills(
                                $positionArray,
                                $positionSkillArray,
                                $extraPlayersCount
                            );
    
            return array_merge($positionSkillArray, $extraPlayers);
        } catch (\Exception $e) {
            throw $e;
        }
    }



    private function choosePlayersBySkills($positionArray, $positionSkillArray, $limit)
    {
        try {
            $extraObjects = [];

            foreach ($positionArray as $position) {
                $found = false;
                $parentTotalSkill = 0;

                foreach ($position['skills'] as $skill) {
                    $parentTotalSkill += $skill['value'];
                }

                foreach ($positionSkillArray as $positionSkill) {
                    if ($position['id'] === $positionSkill['id']) {
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $extraObjects[] = ['data' => $position, 'total_skill' => $parentTotalSkill];
                }
            }

            usort($extraObjects, function ($a, $b) {
                return $b['total_skill'] <=> $a['total_skill'];
            });

            return array_map(function ($item) {
                return $item['data'];
            }, array_slice($extraObjects, 0, $limit));
        } catch (\Exception $e) {
            throw $e;
        }
        
    }
}
