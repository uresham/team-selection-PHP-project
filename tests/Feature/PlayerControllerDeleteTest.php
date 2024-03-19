<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\Player;

use Illuminate\Support\Facades\Config;
class PlayerControllerDeleteTest extends PlayerControllerBaseTest
{

    public function test_sample()
    {

        $player = Player::factory()->create();

        $token = Config::get('app.bearer_token');

        $res = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete(self::REQ_URI . $player->id);


        $this->assertNotNull($res);

        $res->assertStatus(200)
            ->assertJson([
                'message' => 'Player deleted successfully',
            ]);
    }


    public function test_unauthorized()
    {

        $player = Player::factory()->create();

        $res = $this->delete(self::REQ_URI . $player->id);


        $this->assertNotNull($res);

        $res->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthorized.',
            ]);
    }
}
