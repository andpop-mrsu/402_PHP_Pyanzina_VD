<?php

namespace iambadatnicknames\GCD\View;

use function cli\line;
use function cli\prompt;

function showWelcome(): void
{
    line('Добро пожаловать в GCD!');
}

function askName(): string
{
    return prompt('Как вас зовут?');
}

function greet(string $name): void
{
    line("Привет, %s!", $name);
}

function showRules(): void
{
    line('Найдите наибольший общий делитель двух чисел.');
}

function askQuestion(int $a, int $b): string
{
    line("Вопрос: %d %d", $a, $b);
    return prompt('Ваш ответ');
}

function showCorrect(): void
{
    line('Правильно!');
}

function showWrong(string $userAnswer, int $correctAnswer, string $name): void
{
    line(
        "'%s' — неправильный ответ ;(. Правильный ответ: '%d'.",
        $userAnswer,
        $correctAnswer
    );
    line("Попробуйте ещё раз, %s!", $name);
}

function showWin(string $name): void
{
    line("Поздравляем, %s!", $name);
}
