<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', function (Request $request, Response $response) {
    $html = file_get_contents(__DIR__ . '/../public/index.html');
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
});


$app->get('/games', function (Request $request, Response $response) {
    $db    = getDb();
    $stmt  = $db->query('SELECT * FROM games ORDER BY id DESC');
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return jsonResponse($response, $games);
});



$app->get('/games/{id}', function (Request $request, Response $response, array $args) {
    $db = getDb();
    $id = (int) $args['id'];

    $stmt = $db->prepare('SELECT * FROM games WHERE id = ?');
    $stmt->execute([$id]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$game) {
        return jsonResponse($response, ['error' => 'Игра не найдена'], 404);
    }

    $stmt = $db->prepare('SELECT * FROM steps WHERE game_id = ? ORDER BY step_number');
    $stmt->execute([$id]);
    $game['steps'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return jsonResponse($response, $game);
});


$app->post('/games', function (Request $request, Response $response) {
    $data       = $request->getParsedBody();
    $playerName = trim($data['player_name'] ?? 'Аноним');

    if ($playerName === '') {
        $playerName = 'Аноним';
    }

    $db   = getDb();
    $stmt = $db->prepare(
        'INSERT INTO games (player_name, date, total_questions, correct_answers)
         VALUES (?, ?, 0, 0)'
    );
    $stmt->execute([$playerName, date('Y-m-d H:i:s')]);
    $id = (int) $db->lastInsertId();

    return jsonResponse($response, ['id' => $id], 201);
});


$app->post('/step/{id}', function (Request $request, Response $response, array $args) {
    $gameId = (int) $args['id'];
    $data   = $request->getParsedBody();

    $number1      = (int) ($data['number1']      ?? 0);
    $number2      = (int) ($data['number2']      ?? 0);
    $playerAnswer = (int) ($data['player_answer'] ?? 0);

    $correctAnswer = gcd($number1, $number2);
    $isCorrect     = ($playerAnswer === $correctAnswer) ? 1 : 0;

    $db = getDb();

    $stmt = $db->prepare('SELECT COUNT(*) AS cnt FROM steps WHERE game_id = ?');
    $stmt->execute([$gameId]);
    $stepNumber = (int) $stmt->fetch(PDO::FETCH_ASSOC)['cnt'] + 1;

    $stmt = $db->prepare(
        'INSERT INTO steps (game_id, step_number, number1, number2,
                            correct_answer, player_answer, is_correct)
         VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([
        $gameId,
        $stepNumber,
        $number1,
        $number2,
        $correctAnswer,
        $playerAnswer,
        $isCorrect
    ]);

    $stmt = $db->prepare(
        'UPDATE games
            SET total_questions = total_questions + 1,
                correct_answers = correct_answers + ?
          WHERE id = ?'
    );
    $stmt->execute([$isCorrect, $gameId]);

    return jsonResponse($response, [
        'step_number'    => $stepNumber,
        'correct_answer' => $correctAnswer,
        'is_correct'     => (bool) $isCorrect,
    ]);
});
