<?php

namespace App\Services\Strategies;

use App\Contracts\TeamSelectionStrategy;
use App\Repositories\TeamSelectionRepository;
use App\Services\PlayerRequirement;
use App\Services\Strategies\ExactPositionSkillSelectionStrategy;
use Exception;

class TeamSelectionByPositionAndSkillsStrategy implements TeamSelectionStrategy
{
    protected $teamSelectionRepository;

    public function __construct( TeamSelectionRepository $teamSelectionRepository )
    {
        $this->teamSelectionRepository = $teamSelectionRepository;
    }


    public function selectTeam(array $requirements): array
    {
        try {
            $playerRequirements = [];

            // loop through the team requirements to check sufficient players before selecting players.
            foreach ($requirements as $requirement) {
                $playersByPosition = $this->teamSelectionRepository->findByPosition($requirement['position']);

                if (count($playersByPosition) < $requirement['numberOfPlayers']) {
                    throw new Exception("Insufficient number of players for position: {$requirement['position']}");
                }
                
                $playersByPositionAndSkill = $this->teamSelectionRepository
                    ->findByPositionAndSkill(
                        $requirement['position'],
                        $requirement['mainSkill']
                    );
                
                
                // used strategy design pattern for player selection.
                $strategy = new ExactPositionSkillSelectionStrategy();
                if (count($playersByPositionAndSkill) < $requirement['numberOfPlayers']) {
                    $strategy = new SkillSelectionStrategy();
                }
                $playerRequirement = new PlayerRequirement(
                                                $playersByPosition,
                                                $playersByPositionAndSkill,
                                                $strategy, $requirement);
                $playerRequirements[] = $playerRequirement;
            }

            // player selection by running strategies.
            $selectedPlayers = [];
            foreach ($playerRequirements as $playerRequirement) {

                $players = $playerRequirement->strategy->selectPlayers(
                        $playerRequirement->positionArray,
                        $playerRequirement->positionSkillArray,
                        $playerRequirement->requirement,
                    );

                
                $selectedPlayers = array_merge($selectedPlayers, $players);
            }


            return $selectedPlayers;
        } catch (\Exception $e) {
            throw $e;
        }
        
    }
}
