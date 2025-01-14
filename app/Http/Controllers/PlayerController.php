<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
{
    public function index()
    {
        return response()->json(Player::where("status",0)->get());
    }
    public function deletePlayerFromTeam(Request $request, $playerId)
    {
        $teamId = $request->input('team_id');

        $team = Team::find($teamId);
        $player = Player::find($playerId);

        if ($team && $player) {
            $player->update(["status" =>0]);
            $team->players()->detach($playerId);

            return response()->json(['message' => 'Player successfully removed from team'], 200);
        }

        return response()->json(['message' => 'Player or team not found'], 404);
    }
    // public function removePlayerFromTeam(Request $request, $playerId)
    // {
    //     $data = $request->all();
    //     $teamId = $data['team_id'];

    //     $player = Player::find($playerId);
    //     $team = Team::find($teamId);

    //     if ($player && $team) {
    //         $player->update(["status" =>0]);
    //         $team->players()->detach($playerId);
    //         return response()->json(['message' => 'Player removed from team'], 200);
    //     }

    //     return response()->json(['message' => 'Player or team not found'], 404);
    // }
    public function updatePlayerTeam(Request $request, $playerId)
    {
        $data = $request->all();
        $teamId = $data['team_id'];
        $status = $data['status'];


        $player = Player::find($playerId);
        $team = Team::find($teamId);

        if ($player && $team) {
            if ($status === 1) {
                $team->players()->attach($playerId, ['sort_order' => $data['sort_order']]);
            } else {
                $team->players()->detach($playerId);
            }

            return response()->json(['message' => 'Player updated in team'], 200);
        }

        return response()->json(['message' => 'Player or team not found'], 404);
    }

    public function updatePlayerStatus(Request $request,$id) {
        $player = Player::find($id);
        $player->update(["status" =>1]);
        return response()->json(['message' => 'Player updated'], 200);
    }
}
