<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GameController::class, 'home'])->name('home');
Route::get('/new-game', [GameController::class, 'newGame'])->name('new-game');
Route::post('/start-game', [GameController::class, 'startGame'])->name('start-game');
Route::get('/play/{gameId}', [GameController::class, 'play'])->name('play');
Route::post('/answer/{gameId}', [GameController::class, 'submitAnswer'])->name('answer');
Route::get('/games', [GameController::class, 'gamesList'])->name('games');
Route::get('/games/{id}', [GameController::class, 'gameDetails'])->name('game-details');
