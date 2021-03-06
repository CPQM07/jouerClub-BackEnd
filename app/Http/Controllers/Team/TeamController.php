<?php

namespace App\Http\Controllers\Team;

use App\Branch;
use App\Team;
use App\Jouer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\TeamRequest;
use App\Http\Controllers\ApiController;
use App\Transformers\TeamTransformer;

class TeamController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('transform.input:' . TeamTransformer::class)->only(['store', 'update']);
    }

    public function index()
    {
        $teams = Team::all();
        return $this->showAll($teams);
    }

    public function store(TeamRequest $request)
    {
        $fields                  = $request->all();
        $fields['name']          = ucwords($request->name);     
        $fields['motto']         = ucwords($request->motto);

        $jouer = Jouer::findOrFail($request->jouer_id);
        
        if (Branch::findOrFail($request->branch_id)) {

            $today = Carbon::now()->toDateTimeString();
            $change_date = str_replace(" ", "-", $today);
            $name = $change_date."-team-".str_random(10); 
        
            if (empty($request->avatar)) {
                //set default image 
                $fields['avatar'] = "teams/team.png"; 
            } else {
                $fields['avatar']  = $request->avatar->storeAs('teams', $name);
            }

            $team = Team::create($fields);
            $current_team = Team::all()->last()->id;
            $jouer->teams()->attach(array($current_team)); 
            return $this->showOne($team, 201);
        }
    }

    public function show(Team $team)
    {
        return $this->showOne($team);        
    }

    public function update(Request $request, Team $team)
    {
        if ($request->has('name')) {
            $team->name = $request->name;
        }

        if ($request->has('motto')) {
            $team->motto = $request->motto;
        }

        if (!$team->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $team->save();
        return $this->showOne($team);
    }

    public function destroy(Team $team)
    {
    	$team->delete();
        return $this->showOne($team);
    }
}



