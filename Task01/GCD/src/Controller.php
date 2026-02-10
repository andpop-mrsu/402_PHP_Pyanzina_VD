<?php

namespace iambadatnicknames\GCD\Controller;

use function iambadatnicknames\GCD\View\showWelcome;
use function iambadatnicknames\GCD\View\askName;
use function iambadatnicknames\GCD\View\greet;
use function iambadatnicknames\GCD\View\showRules;
use function iambadatnicknames\GCD\View\askQuestion;
use function iambadatnicknames\GCD\View\showCorrect;
use function iambadatnicknames\GCD\View\showWrong;
use function iambadatnicknames\GCD\View\showWin;

function gcd(int $a, int $b): int
{
    while ($b !== 0) {
        $t = $b;
        $b = $a % $b;
        $a = $t;
    }
    return $a;
}

function startGame(): void
{
    showWelcome();
    $name = askName();
    greet($name);
    showRules();

    $rounds = 3;

    for ($i = 0; $i < $rounds; $i++) {
        $num1 = rand(1, 100);
        $num2 = rand(1, 100);
        $correct = gcd($num1, $num2);

        $answer = askQuestion($num1, $num2);

        if ((int) $answer === $correct) {
            showCorrect();
        } else {
            showWrong($answer, $correct, $name);
            return;
        }
    }

    showWin($name);
}
