<?php

namespace Database\Factories;

use App\Enums\PlayerPosition;
use App\Models\Player;
use App\Models\PlayerSkill;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $positions = [
            PlayerPosition::DEFENDER,
            PlayerPosition::MIDFIELDER,
            PlayerPosition::FORWARD,
        ];

        return [
            'name' => $this->faker->name,
            'position' => $this->faker->randomElement($positions),
        ];
    }


    public function configure()
    {
        return $this->afterCreating(function (Player $player) {

            // Create 2 PlayerSkills for each player
            \App\Models\PlayerSkill::factory()->count(2)->create([
                'player_id' => $player->id,
            ]);
        });
    }
}
