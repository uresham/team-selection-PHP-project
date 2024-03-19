<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\Player;
use App\Models\PlayerSkill;

class TeamControllerTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        Player::factory()->create();

        $requirements =
            [
                [
                    'position' => "defender",
                    'mainSkill' => "speed",
                    'numberOfPlayers' => 1
                ]
            ];


        $res = $this->postJson(self::REQ_TEAM_URI, $requirements);

        $res->assertStatus(200);
        $this->assertNotNull($res);

        if( key_exists('message', $res->json())) {
            $this->assertEquals("Insufficient number of players for position: {$requirements[0]['position']}",
                                $res['message']);
        } else {
            $res->assertJsonStructure([
                '*' => [
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
                ],
            ]);
        }

    }
}
