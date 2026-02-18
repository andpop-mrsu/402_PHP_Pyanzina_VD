
const state = {
    gameId: null,
    playerName: '',
    roundNumber: 0,
    number1: 0,
    number2: 0,
    totalCorrect: 0,
    totalQuestions: 0,
    lastResult: null
};

const content = document.getElementById('content');


function rand(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function genNumbers() {
    state.number1 = rand(2, 99);
    state.number2 = rand(2, 99);
}

async function api(method, url, body) {
    const opts = {
        method,
        headers: { 'Content-Type': 'application/json' }
    };
    if (body) {
        opts.body = JSON.stringify(body);
    }
    const res = await fetch(url, opts);
    return res.json();
}


function viewHome() {
    content.innerHTML = `
        <p class="subtitle">Найдите наибольший общий делитель двух чисел!</p>
        <div class="center">
            <button class="btn btn-primary" onclick="viewNewGame()">🎮 Новая игра</button>
            <button class="btn btn-secondary" onclick="viewGamesList()">📋 История игр</button>
        </div>
    `;
}

function viewNewGame() {
    content.innerHTML = `
        <h2>Новая игра</h2>
        <label for="inp-name">Имя игрока</label>
        <input type="text" id="inp-name" placeholder="Введите имя" autofocus>
        <div class="center mt-10">
            <button class="btn btn-primary" onclick="startGame()">Начать</button>
            <button class="btn btn-gray" onclick="viewHome()">Назад</button>
        </div>
    `;
    document.getElementById('inp-name').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') startGame();
    });
}

async function startGame() {
    const name = document.getElementById('inp-name').value.trim();
    if (!name) {
        alert('Введите имя!');
        return;
    }

    state.playerName = name;
    state.roundNumber = 0;
    state.totalCorrect = 0;
    state.totalQuestions = 0;
    state.lastResult = null;

    const res = await api('POST', '/games', { player_name: name });
    state.gameId = res.id;
    nextRound();
}

function nextRound() {
    state.roundNumber++;
    genNumbers();
    state.lastResult = null;
    viewPlaying();
}

function viewPlaying() {
    let resHtml = '';
    if (state.lastResult) {
        if (state.lastResult.is_correct) {
            resHtml = `<div class="result-box result-correct">
                ✅ Правильно! НОД = ${state.lastResult.correct_answer}
            </div>`;
        } else {
            resHtml = `<div class="result-box result-incorrect">
                ❌ Неправильно! Правильный ответ: ${state.lastResult.correct_answer}
            </div>`;
        }
    }

    const answered = state.lastResult !== null;

    content.innerHTML = `
        <div class="round-info">
            Раунд ${state.roundNumber} &nbsp;|&nbsp;
            Верно: ${state.totalCorrect} / ${state.totalQuestions}
        </div>
        <div class="numbers-display">${state.number1} &nbsp;и&nbsp; ${state.number2}</div>
        <label for="inp-answer">Введите НОД:</label>
        <input type="number" id="inp-answer" placeholder="Ваш ответ"
               ${answered ? 'disabled' : ''} autofocus>
        ${resHtml}
        <div class="center mt-10">
            ${!answered
            ? '<button class="btn btn-primary" onclick="submitAnswer()">Ответить</button>'
            : '<button class="btn btn-primary" onclick="nextRound()">Следующий вопрос</button>'}
            <button class="btn btn-danger" onclick="endGame()">Завершить игру</button>
        </div>
    `;

    if (!answered) {
        const inp = document.getElementById('inp-answer');
        inp.focus();
        inp.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') submitAnswer();
        });
    }
}

async function submitAnswer() {
    const val = document.getElementById('inp-answer').value.trim();
    if (val === '' || isNaN(val)) {
        alert('Введите целое число!');
        return;
    }

    const res = await api('POST', `/step/${state.gameId}`, {
        number1: state.number1,
        number2: state.number2,
        player_answer: parseInt(val)
    });

    state.lastResult = res;
    state.totalQuestions++;
    if (res.is_correct) state.totalCorrect++;

    viewPlaying();
}

function endGame() {
    content.innerHTML = `
        <h2 class="center">Игра завершена!</h2>
        <p class="center mb-12">Игрок: <strong>${state.playerName}</strong></p>
        <div class="score">${state.totalCorrect} / ${state.totalQuestions}</div>
        <p class="center mb-12" style="color:#7f8c8d">правильных ответов</p>
        <div class="center mt-20">
            <button class="btn btn-primary" onclick="viewNewGame()">🎮 Новая игра</button>
            <button class="btn btn-secondary" onclick="viewHome()">На главную</button>
        </div>
    `;
}

async function viewGamesList() {
    const games = await api('GET', '/games');

    let rows = '';
    if (games.length === 0) {
        rows = '<tr><td colspan="4" class="empty-msg">Пока нет сохранённых игр</td></tr>';
    } else {
        games.forEach(function (g) {
            rows += `<tr>
                <td class="link" onclick="viewGameDetails(${g.id})">${g.id}</td>
                <td>${g.player_name}</td>
                <td>${g.date}</td>
                <td>${g.correct_answers} / ${g.total_questions}</td>
            </tr>`;
        });
    }

    content.innerHTML = `
        <h2>История игр</h2>
        <table>
            <thead>
                <tr><th>#</th><th>Игрок</th><th>Дата</th><th>Результат</th></tr>
            </thead>
            <tbody>${rows}</tbody>
        </table>
        <div class="center mt-10">
            <button class="btn btn-gray" onclick="viewHome()">На главную</button>
        </div>
    `;
}

async function viewGameDetails(id) {
    const game = await api('GET', `/games/${id}`);

    let rows = '';
    game.steps.forEach(function (s) {
        rows += `<tr>
            <td>${s.step_number}</td>
            <td>${s.number1}</td>
            <td>${s.number2}</td>
            <td>${s.correct_answer}</td>
            <td>${s.player_answer}</td>
            <td>${s.is_correct == 1 ? '✅' : '❌'}</td>
        </tr>`;
    });

    content.innerHTML = `
        <h2>Игра #${game.id}</h2>
        <p class="mb-12"><strong>Игрок:</strong> ${game.player_name}</p>
        <p class="mb-12"><strong>Дата:</strong> ${game.date}</p>
        <p class="mb-12"><strong>Результат:</strong> ${game.correct_answers} / ${game.total_questions}</p>
        <table>
            <thead>
                <tr><th>№</th><th>Число 1</th><th>Число 2</th><th>НОД</th><th>Ответ</th><th></th></tr>
            </thead>
            <tbody>${rows}</tbody>
        </table>
        <div class="center mt-10">
            <button class="btn btn-secondary" onclick="viewGamesList()">← К списку</button>
            <button class="btn btn-gray" onclick="viewHome()">На главную</button>
        </div>
    `;
}

viewHome();