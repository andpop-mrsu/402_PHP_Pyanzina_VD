@extends('layouts.app')

@section('content')
<div class="round-info">
    Верно: {{ $game->correct_answers }} / {{ $game->total_questions }}
</div>
<div class="numbers-display">{{ $number1 }} &nbsp;и&nbsp; {{ $number2 }}</div>

@if ($isCorrect)
<div class="result-box result-correct">
    ✅ Правильно! НОД = {{ $correctAnswer }}
</div>
@else
<div class="result-box result-incorrect">
    ❌ Неправильно! Ваш ответ: {{ $playerAnswer }}. Правильный ответ: {{ $correctAnswer }}
</div>
@endif

<div class="center mt-20">
    <a href="{{ route('play', $game->id) }}" class="btn btn-primary">Следующий вопрос</a>
    <a href="{{ route('home') }}" class="btn btn-danger">Завершить игру</a>
</div>
@endsection