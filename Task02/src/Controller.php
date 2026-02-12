<?php

namespace iambadatnicknames\GCD\Controller;

use function iambadatnicknames\GCD\Database\createGame;
use function iambadatnicknames\GCD\Database\addRound;
use function iambadatnicknames\GCD\Database\updateGameResult;

function gcd(int $a, int $b): int
{
    while ($b !== 0) {
        $t = $b;
        $b = $a % $b;
        $a = $t;
    }

    return $a;
}

function startGame(string $playerName): array
{
    $gameId = createGame($playerName);
    $num1 = rand(1, 100);
    $num2 = rand(1, 100);
    $correctAnswer = gcd($num1, $num2);

    return [
        'gameId' => $gameId,
        'playerName' => $playerName,
        'num1' => $num1,
        'num2' => $num2,
        'correctAnswer' => $correctAnswer,
        'round' => 1,
        'maxRounds' => 3,
    ];
}

function processAnswer(
    int $gameId,
    string $playerName,
    int $num1,
    int $num2,
    int $correctAnswer,
    string $playerAnswer,
    int $round
): array {
    $isCorrect = ((int) $playerAnswer === $correctAnswer);

    addRound($gameId, $num1, $num2, $correctAnswer, $playerAnswer, $isCorrect);

    if (!$isCorrect) {
        updateGameResult($gameId, 'loss');
        return [
            'status' => 'wrong',
            'playerName' => $playerName,
            'playerAnswer' => $playerAnswer,
            'correctAnswer' => $correctAnswer,
            'gameId' => $gameId,
        ];
    }

    if ($round >= 3) {
        updateGameResult($gameId, 'win');
        return [
            'status' => 'win',
            'playerName' => $playerName,
            'gameId' => $gameId,
        ];
    }

    $newNum1 = rand(1, 100);
    $newNum2 = rand(1, 100);
    $newCorrectAnswer = gcd($newNum1, $newNum2);

    return [
        'status' => 'correct',
        'gameId' => $gameId,
        'playerName' => $playerName,
        'num1' => $newNum1,
        'num2' => $newNum2,
        'correctAnswer' => $newCorrectAnswer,
        'round' => $round + 1,
        'maxRounds' => 3,
    ];
}
