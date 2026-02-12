<?php

namespace iambadatnicknames\GCD\View;

function renderHeader(string $title = 'GCD'): void
{
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title) ?></title>
        <link rel="stylesheet" href="/style.css">
    </head>
    <body>
    <div class="container">
        <nav>
            <a href="/">Главная</a> |
            <a href="/history.php">История игр</a>
        </nav>
        <h1><?= htmlspecialchars($title) ?></h1>
    <?php
}

function renderFooter(): void
{
    ?>
    </div>
    </body>
    </html>
    <?php
}

function renderIndex(): void
{
    renderHeader('Добро пожаловать в GCD!');
    ?>
    <p>Найдите наибольший общий делитель двух чисел.</p>
    <p>Игра состоит из 3 раундов. Для победы нужно ответить правильно во всех раундах.</p>

    <form action="/play.php" method="post">
        <label for="name">Как вас зовут?</label><br>
        <input type="text" id="name" name="name" required placeholder="Введите имя"><br><br>
        <button type="submit">Начать игру</button>
    </form>
    <?php
    renderFooter();
}

function renderQuestion(array $data): void
{
    renderHeader('Раунд ' . $data['round'] . ' из ' . $data['maxRounds']);
    ?>
    <p>Привет, <strong><?= htmlspecialchars($data['playerName']) ?></strong>!</p>
    <p>Найдите наибольший общий делитель двух чисел:</p>
    <p class="question"><?= $data['num1'] ?> и <?= $data['num2'] ?></p>

    <form action="/result.php" method="post">
        <input type="hidden" name="game_id" value="<?= $data['gameId'] ?>">
        <input type="hidden" name="player_name" value="<?= htmlspecialchars($data['playerName']) ?>">
        <input type="hidden" name="num1" value="<?= $data['num1'] ?>">
        <input type="hidden" name="num2" value="<?= $data['num2'] ?>">
        <input type="hidden" name="correct_answer" value="<?= $data['correctAnswer'] ?>">
        <input type="hidden" name="round" value="<?= $data['round'] ?>">

        <label for="answer">Ваш ответ:</label><br>
        <input type="number" id="answer" name="answer" required placeholder="Введите НОД"><br><br>
        <button type="submit">Ответить</button>
    </form>
    <?php
    renderFooter();
}

function renderWrong(array $data): void
{
    renderHeader('Неправильный ответ');
    ?>
    <p>
        '<strong><?= htmlspecialchars($data['playerAnswer']) ?></strong>'
        — неправильный ответ ;(. Правильный ответ: '<strong><?= $data['correctAnswer'] ?></strong>'.
    </p>
    <p>Попробуйте ещё раз, <strong><?= htmlspecialchars($data['playerName']) ?></strong>!</p>

    <a href="/" class="button">Начать заново</a>
    <?php
    renderFooter();
}

function renderWin(array $data): void
{
    renderHeader('Победа!');
    ?>
    <p>Поздравляем, <strong><?= htmlspecialchars($data['playerName']) ?></strong>!</p>
    <p>Вы правильно ответили на все вопросы!</p>

    <a href="/" class="button">Играть снова</a>
    <?php
    renderFooter();
}

function renderHistory(array $games): void
{
    renderHeader('История игр');
    ?>
    <?php if (empty($games)) : ?>
        <p>Пока нет сыгранных игр.</p>
    <?php else : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Игрок</th>
                    <th>Дата</th>
                    <th>Результат</th>
                    <th>Подробности</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($games as $game) : ?>
                    <tr>
                        <td><?= $game['id'] ?></td>
                        <td><?= htmlspecialchars($game['player_name']) ?></td>
                        <td><?= htmlspecialchars($game['date']) ?></td>
                        <td>
                            <?php if ($game['result'] === 'win') : ?>
                                <span class="win">Победа</span>
                            <?php elseif ($game['result'] === 'loss') : ?>
                                <span class="loss">Поражение</span>
                            <?php else : ?>
                                <span>В процессе</span>
                            <?php endif; ?>
                        </td>
                        <td><a href="/history.php?game_id=<?= $game['id'] ?>">Подробнее</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <?php
    renderFooter();
}

function renderGameDetails(array $game, array $rounds): void
{
    renderHeader('Игра #' . $game['id']);
    ?>
    <p><strong>Игрок:</strong> <?= htmlspecialchars($game['player_name']) ?></p>
    <p><strong>Дата:</strong> <?= htmlspecialchars($game['date']) ?></p>
    <p><strong>Результат:</strong>
        <?php if ($game['result'] === 'win') : ?>
            <span class="win">Победа</span>
        <?php elseif ($game['result'] === 'loss') : ?>
            <span class="loss">Поражение</span>
        <?php else : ?>
            В процессе
        <?php endif; ?>
    </p>

    <h2>Раунды</h2>
    <?php if (empty($rounds)) : ?>
        <p>Нет данных о раундах.</p>
    <?php else : ?>
        <table>
            <thead>
                <tr>
                    <th>Раунд</th>
                    <th>Число 1</th>
                    <th>Число 2</th>
                    <th>НОД</th>
                    <th>Ответ игрока</th>
                    <th>Результат</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rounds as $index => $round) : ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $round['num1'] ?></td>
                        <td><?= $round['num2'] ?></td>
                        <td><?= $round['correct_answer'] ?></td>
                        <td><?= htmlspecialchars($round['player_answer']) ?></td>
                        <td>
                            <?php if ($round['is_correct']) : ?>
                                <span class="win">Правильно ✓</span>
                            <?php else : ?>
                                <span class="loss">Неправильно ✗</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <br>
    <a href="/history.php" class="button">← К списку игр</a>
    <?php
    renderFooter();
}