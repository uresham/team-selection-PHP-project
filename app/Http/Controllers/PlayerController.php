<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW.
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;
use App\Models\Player;
use App\Transformers\PlayerTransformer;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlayerController extends Controller
{
    public function index()
    {
        try {
            $players = Player::all();

            if (!$players) {
                return response()->json(['message' => 'No Players Found.'], 200);
            }
    
            $transformer =  new PlayerTransformer();
            $transformedPlayers = $transformer->transformCollection($players->toArray());

            return response( $transformedPlayers, 200);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(array(
                'message' => $e->getMessage()
            ), 500));
        }
    }

    public function show($playerId)
    {
        try {
            $player = Player::find($playerId);

            if (!$player) {
                return response()->json(['message' => 'Player not found'], 200);
            }
    
            $transformer =  new PlayerTransformer();
            $transformedPlayer = $transformer->transform($player->toArray());

            return response($transformedPlayer, 200);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(array(
                'message' => $e->getMessage()
            ), 500));
        }
    }

    public function store(PlayerRequest $request)
    {
        try {
            $player = Player::create($request->validated());
            $skills = $request->input('playerSkills');
            foreach ($skills as $skill) {
                $player->skills()->create($skill);
            }

            $transformer =  new PlayerTransformer();
            $transformedPlayer = $transformer->transform(Player::find($player->id)->toArray());

            return response($transformedPlayer, 200);
            
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(array(
                'message' => $e->getMessage()
            ), 500));
        }
        
    }

    public function update(PlayerRequest $request, $playerId)
    {

       try {
            $player = Player::find($playerId);

            if (!$player) {
                return response()->json(['message' => 'Player not found'], 200);
            }


            $player->update($request->validated());
            $player->skills()->delete(); // Delete existing skills before updating
            
            $skills = $request->input('playerSkills');
            foreach ($skills as $skill) {
                $player->skills()->create($skill);
            }

            $transformer =  new PlayerTransformer();
            $transformedPlayer = $transformer->transform(Player::find($playerId)->toArray());

            return response($transformedPlayer, 200);
       } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(array(
                'message' => $e->getMessage()
            ), 500));
        }
    }

    public function destroy($playerId)
    {
        try {
            $player = Player::find($playerId);
            $player->delete();
            return response()->json(array(
                'message' => 'Player deleted successfully'
            ), 200);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(array(
                'message' => $e->getMessage()
            ), 500));
        }
    }
}
