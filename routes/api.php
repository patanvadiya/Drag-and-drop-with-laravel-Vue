<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/teams', [TeamController::class, 'index']);
Route::get('/players', [PlayerController::class, 'index']);
Route::get('/update-player', [PlayerController::class, 'updatePlayerTeam']);
Route::get('/update-player-status/{id}', [PlayerController::class, 'updatePlayerStatus']);
Route::get('/delete-player', [PlayerController::class, 'deletePlayer']);
Route::post('/save-teams', [TeamController::class, 'save']);
Route::delete('/delete-player/{playerId}', [PlayerController::class, 'deletePlayerFromTeam']);

