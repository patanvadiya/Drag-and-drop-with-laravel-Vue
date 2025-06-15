<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use App\Models\TeamPlayer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{

    public function index()
    {
        $teams = Team::with('players')->get();
        return response()->json($teams);
    }



    public function save(Request $request)
    {
        $data = $request->all();

        Team::with('players')->get()->each(function ($team) {
            $team->players()->detach();
        });

        foreach ($data as $teamData) {

            foreach ($teamData as $val) {
                $team = Team::find($val['team_id']);
                foreach ($val['players'] as $playerData) {
                    $team->players()->attach($playerData['id'], ['sort_order' => $playerData['sort_order']]);
                    $player = Player::find($playerData['id']);
                    $player->update(["permanent_status" =>1]);
                }
            }
        }

        return response()->json(['message' => 'Teams updated successfully']);
    }
}

