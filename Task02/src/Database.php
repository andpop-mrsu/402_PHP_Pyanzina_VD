<?php

namespace iambadatnicknames\GCD\Database;

use SQLite3;

function getConnection(): SQLite3
{
    static $db = null;

    if ($db === null) {
        $dbPath = __DIR__ . '/../db/database.sqlite';
        $dbDir = dirname($dbPath);

        if (!is_dir($dbDir)) {
            mkdir($dbDir, 0755, true);
        }

        $db = new SQLite3($dbPath);
        $db->exec('PRAGMA journal_mode=WAL');
        createTables($db);
    }

    return $db;
}

function createTables(SQLite3 $db): void
{
    $db->exec('
        CREATE TABLE IF NOT EXISTS games (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            player_name TEXT NOT NULL,
            date TEXT NOT NULL,
            result TEXT NOT NULL
        )
    ');

    $db->exec('
        CREATE TABLE IF NOT EXISTS rounds (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            game_id INTEGER NOT NULL,
            num1 INTEGER NOT NULL,
            num2 INTEGER NOT NULL,
            correct_answer INTEGER NOT NULL,
            player_answer TEXT,
            is_correct INTEGER NOT NULL,
            FOREIGN KEY (game_id) REFERENCES games(id)
        )
    ');
}

function createGame(string $playerName): int
{
    $db = getConnection();
    $stmt = $db->prepare('
        INSERT INTO games (player_name, date, result)
        VALUES (:name, :date, :result)
    ');
    $stmt->bindValue(':name', $playerName, SQLITE3_TEXT);
    $stmt->bindValue(':date', date('Y-m-d H:i:s'), SQLITE3_TEXT);
    $stmt->bindValue(':result', 'in_progress', SQLITE3_TEXT);
    $stmt->execute();

    return (int) $db->lastInsertRowID();
}

function addRound(
    int $gameId,
    int $num1,
    int $num2,
    int $correctAnswer,
    string $playerAnswer,
    bool $isCorrect
): void {
    $db = getConnection();
    $stmt = $db->prepare('
        INSERT INTO rounds (game_id, num1, num2, correct_answer, player_answer, is_correct)
        VALUES (:game_id, :num1, :num2, :correct, :player, :is_correct)
    ');
    $stmt->bindValue(':game_id', $gameId, SQLITE3_INTEGER);
    $stmt->bindValue(':num1', $num1, SQLITE3_INTEGER);
    $stmt->bindValue(':num2', $num2, SQLITE3_INTEGER);
    $stmt->bindValue(':correct', $correctAnswer, SQLITE3_INTEGER);
    $stmt->bindValue(':player', $playerAnswer, SQLITE3_TEXT);
    $stmt->bindValue(':is_correct', $isCorrect ? 1 : 0, SQLITE3_INTEGER);
    $stmt->execute();
}

function updateGameResult(int $gameId, string $result): void
{
    $db = getConnection();
    $stmt = $db->prepare('UPDATE games SET result = :result WHERE id = :id');
    $stmt->bindValue(':result', $result, SQLITE3_TEXT);
    $stmt->bindValue(':id', $gameId, SQLITE3_INTEGER);
    $stmt->execute();
}

function getGame(int $gameId): array|false
{
    $db = getConnection();
    $stmt = $db->prepare('SELECT * FROM games WHERE id = :id');
    $stmt->bindValue(':id', $gameId, SQLITE3_INTEGER);
    $result = $stmt->execute();

    return $result->fetchArray(SQLITE3_ASSOC);
}

function getAllGames(): array
{
    $db = getConnection();
    $result = $db->query('SELECT * FROM games ORDER BY date DESC');
    $games = [];

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $games[] = $row;
    }

    return $games;
}

function getRounds(int $gameId): array
{
    $db = getConnection();
    $stmt = $db->prepare('SELECT * FROM rounds WHERE game_id = :game_id ORDER BY id');
    $stmt->bindValue(':game_id', $gameId, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $rounds = [];

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $rounds[] = $row;
    }

    return $rounds;
}
