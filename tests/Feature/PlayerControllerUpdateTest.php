<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;

class PlayerControllerUpdateTest extends PlayerControllerBaseTest
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

        $res = $this->putJson(self::REQ_URI . '1', $data);

        $this->assertNotNull($res);
    }

    public function test_update_player_with_invalid_position()
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

        $res = $this->putJson(self::REQ_URI . '1', $data);

        $res->assertStatus(422)
            ->assertJson([
                'message' => 'Invalid value for position: invalid_position', // Customize error message
            ]);
    }

    public function test_update_player_with_invalid_skill_value()
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

        $res = $this->putJson(self::REQ_URI . '1', $data);

        $res->assertStatus(422)
            ->assertJson([
                'message' => 'Invalid value for playerSkills.0.value: -10', // Customize error message
            ]);
    }


    public function test_no_player_found()
    {
        $data = [
            'name' => "test2",
            'position' => PlayerPosition::MIDFIELDER, 
            'playerSkills' => [
                [
                    'skill' => PlayerSkill::ATTACK,
                    'value' => 80,
                ],
            ],
        ];

        $res = $this->putJson(self::REQ_URI . '100', $data);

        $res->assertStatus(200)
            ->assertJson([
                'message' => 'Player not found',
            ]);
    }
}
