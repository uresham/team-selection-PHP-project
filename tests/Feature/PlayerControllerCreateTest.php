<?php


// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;

class PlayerControllerCreateTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $data = [
            "name" => "test",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "attack",
                    "value" => 60
                ],
                1 => [
                    "skill" => "speed",
                    "value" => 80
                ]
            ]
        ];

        $res = $this->postJson(self::REQ_URI, $data);

        $this->assertNotNull($res);

        $res->assertStatus(200)
        ->assertJsonStructure([
            'id',
            'name',
            'position',
            'playerSkills' => [
                '*' => [
                    'id',
                    'skill',
                    'value',
                    'playerId',
                ],
            ],
        ]);
    }


    public function test_create_player_with_invalid_position()
    {
        $data = [
            'name' => "test2",
            'position' => 'invalid_position', // Invalid position
            'playerSkills' => [
                [
                    'skill' => PlayerSkill::ATTACK,
                    'value' => 80,
                ],
            ],
        ];

        $response = $this->postJson('/api/player', $data);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Invalid value for position: invalid_position', // Customize error message
            ]);
    }

    public function test_create_player_with_invalid_skill_value()
    {
        $data = [
            'name' => "test3",
            'position' => PlayerPosition::MIDFIELDER,
            'playerSkills' => [
                [
                    'skill' => PlayerSkill::ATTACK,
                    'value' => -10, // Invalid skill value (negative)
                ],
            ],
        ];

        $response = $this->postJson('/api/player', $data);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Invalid value for playerSkills.0.value: -10', // Customize error message
            ]);
    }

}
