@extends('layouts.app')

@section('content')
<div class="round-info">
    Раунд {{ $roundNumber }} &nbsp;|&nbsp;
    Верно: {{ $game->correct_answers }} / {{ $game->total_questions }}
</div>
<div class="numbers-display">{{ $number1 }} &nbsp;и&nbsp; {{ $number2 }}</div>
<form action="{{ route('answer', $game->id) }}" method="POST">
    @csrf
    <input type="hidden" name="number1" value="{{ $number1 }}">
    <input type="hidden" name="number2" value="{{ $number2 }}">
    <label for="player_answer">Введите НОД:</label>
    <input type="number" id="player_answer" name="player_answer" placeholder="Ваш ответ" required autofocus>
    <div class="center mt-10">
        <button type="submit" class="btn btn-primary">Ответить</button>
        <a href="{{ route('home') }}" class="btn btn-danger">Завершить игру</a>
    </div>
</form>
@endsection