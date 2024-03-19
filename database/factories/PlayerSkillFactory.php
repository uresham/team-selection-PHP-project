<?php


namespace Database\Factories;

use App\Enums\PlayerSkill;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerSkillFactory extends Factory
{

    public function definition()
    {

        $skills = [
            PlayerSkill::DEFENSE,
            PlayerSkill::ATTACK,
            PlayerSkill::SPEED,
            PlayerSkill::STRENGTH,
            PlayerSkill::STAMINA,
        ];

        return [
            'player_id' => function () {
                return Player::factory()->create()->id;
            },
            'skill' => $this->faker->randomElement($skills),
            'value' => $this->faker->numberBetween(50, 90),
        ];
    }
}