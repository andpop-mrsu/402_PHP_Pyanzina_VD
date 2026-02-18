<?php

function getDb(): PDO
{
    static $db = null;

    if ($db !== null) {
        return $db;
    }

    $dbPath = __DIR__ . '/../db/game.db';
    $dbDir  = dirname($dbPath);

    if (!is_dir($dbDir)) {
        mkdir($dbDir, 0777, true);
    }

    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec('
        CREATE TABLE IF NOT EXISTS games (
            id              INTEGER PRIMARY KEY AUTOINCREMENT,
            player_name     TEXT    NOT NULL,
            date            TEXT    NOT NULL,
            total_questions INTEGER DEFAULT 0,
            correct_answers INTEGER DEFAULT 0
        )
    ');

    $db->exec('
        CREATE TABLE IF NOT EXISTS steps (
            id             INTEGER PRIMARY KEY AUTOINCREMENT,
            game_id        INTEGER NOT NULL,
            step_number    INTEGER NOT NULL,
            number1        INTEGER NOT NULL,
            number2        INTEGER NOT NULL,
            correct_answer INTEGER NOT NULL,
            player_answer  INTEGER NOT NULL,
            is_correct     INTEGER NOT NULL,
            FOREIGN KEY (game_id) REFERENCES games(id)
        )
    ');

    return $db;
}
