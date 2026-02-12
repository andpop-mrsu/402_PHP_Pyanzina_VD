<?php

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Controller.php';
require_once __DIR__ . '/../src/View.php';

use function iambadatnicknames\GCD\Database\getGame;
use function iambadatnicknames\GCD\Database\getAllGames;
use function iambadatnicknames\GCD\Database\getRounds;
use function iambadatnicknames\GCD\View\renderHistory;
use function iambadatnicknames\GCD\View\renderGameDetails;

if (isset($_GET['game_id'])) {
    $gameId = (int) $_GET['game_id'];
    $game = getGame($gameId);

    if ($game === false) {
        header('Location: /history.php');
        exit;
    }

    $rounds = getRounds($gameId);
    renderGameDetails($game, $rounds);
} else {
    $games = getAllGames();
    renderHistory($games);
}
