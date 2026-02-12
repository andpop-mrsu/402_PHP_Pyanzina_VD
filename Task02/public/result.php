<?php

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Controller.php';
require_once __DIR__ . '/../src/View.php';

use function iambadatnicknames\GCD\Controller\processAnswer;
use function iambadatnicknames\GCD\View\renderQuestion;
use function iambadatnicknames\GCD\View\renderWrong;
use function iambadatnicknames\GCD\View\renderWin;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit;
}

$gameId = (int) $_POST['game_id'];
$playerName = $_POST['player_name'];
$num1 = (int) $_POST['num1'];
$num2 = (int) $_POST['num2'];
$correctAnswer = (int) $_POST['correct_answer'];
$playerAnswer = trim($_POST['answer']);
$round = (int) $_POST['round'];

$result = processAnswer(
    $gameId,
    $playerName,
    $num1,
    $num2,
    $correctAnswer,
    $playerAnswer,
    $round
);

switch ($result['status']) {
    case 'correct':
        renderQuestion($result);
        break;
    case 'wrong':
        renderWrong($result);
        break;
    case 'win':
        renderWin($result);
        break;
}
