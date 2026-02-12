<?php

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Controller.php';
require_once __DIR__ . '/../src/View.php';

use function iambadatnicknames\GCD\Controller\startGame;
use function iambadatnicknames\GCD\View\renderQuestion;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['name'])) {
    header('Location: /');
    exit;
}

$playerName = trim($_POST['name']);
$data = startGame($playerName);

renderQuestion($data);
