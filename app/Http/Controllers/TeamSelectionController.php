<?php


namespace App\Http\Controllers;

use App\Http\Requests\TeamSelectionRequest;
use App\Models\Player;
use App\Repositories\TeamSelectionRepository;
use App\Services\Strategies\TeamSelectionByPositionAndSkillsStrategy;
use App\Services\TeamSelectionService;
use App\Transformers\PlayerTransformer;
use Illuminate\Http\Exceptions\HttpResponseException;

class TeamSelectionController extends Controller
{
    protected $teamSelectionRepository;

    public function __construct(TeamSelectionRepository $teamSelectionRepository)
    {
        $this->teamSelectionRepository = $teamSelectionRepository;
    }


    public function selectTeam(TeamSelectionRequest $request)
    {

        try {
            $selectedPlayers = [];

            // used strategy designed pattern for Team Selection. So we can add more strategies to select team in the future.
            $teamContext = new TeamSelectionService(
                                    new TeamSelectionByPositionAndSkillsStrategy($this->teamSelectionRepository)
                                );
            $selectedPlayers = $teamContext->selectTeam($request->all());

            $transformer =  new PlayerTransformer();
            $transformedPlayer = $transformer->transformCollection($selectedPlayers);

            return response($transformedPlayer, 200);
    
        } catch (\Exception $e) {
            if(str_contains( $e->getMessage(), 'Insufficient number of players')) {
                return response()->json(array(
                    'message' => $e->getMessage()
                ), 200);
            } else {
                throw new HttpResponseException(response()->json(array(
                    'message' => $e->getMessage()
                ), 500));
            }
            
        }
    }
}
