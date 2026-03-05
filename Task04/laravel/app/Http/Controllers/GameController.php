<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Step;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function newGame()
    {
        return view('new-game');
    }

    public function startGame(Request $request)
    {
        $request->validate([
            'player_name' => 'required|string|max:255',
        ]);

        $game = Game::create([
            'player_name' => $request->input('player_name'),
        ]);

        return redirect()->route('play', $game->id);
    }

    public function play($gameId)
    {
        $game = Game::findOrFail($gameId);

        $number1 = rand(2, 99);
        $number2 = rand(2, 99);
        $roundNumber = $game->total_questions + 1;

        return view('play', compact('game', 'number1', 'number2', 'roundNumber'));
    }

    public function submitAnswer(Request $request, $gameId)
    {
        $request->validate([
            'number1'       => 'required|integer',
            'number2'       => 'required|integer',
            'player_answer' => 'required|integer',
        ]);

        $game = Game::findOrFail($gameId);

        $number1       = (int) $request->input('number1');
        $number2       = (int) $request->input('number2');
        $playerAnswer  = (int) $request->input('player_answer');
        $correctAnswer = $this->gcd($number1, $number2);
        $isCorrect     = $playerAnswer === $correctAnswer;

        $stepNumber = $game->steps()->count() + 1;

        Step::create([
            'game_id'        => $game->id,
            'step_number'    => $stepNumber,
            'number1'        => $number1,
            'number2'        => $number2,
            'correct_answer' => $correctAnswer,
            'player_answer'  => $playerAnswer,
            'is_correct'     => $isCorrect,
        ]);

        $game->total_questions = $game->steps()->count();
        $game->correct_answers = $game->steps()->where('is_correct', true)->count();
        $game->save();

        return view('result', compact(
            'game',
            'number1',
            'number2',
            'correctAnswer',
            'playerAnswer',
            'isCorrect'
        ));
    }

    public function gamesList()
    {
        $games = Game::orderByDesc('created_at')->get();
        return view('games', compact('games'));
    }

    public function gameDetails($id)
    {
        $game = Game::with(['steps' => function ($q) {
            $q->orderBy('step_number');
        }])->findOrFail($id);

        return view('game-details', compact('game'));
    }

    private function gcd(int $a, int $b): int
    {
        $a = abs($a);
        $b = abs($b);
        while ($b !== 0) {
            [$a, $b] = [$b, $a % $b];
        }
        return $a;
    }
}
