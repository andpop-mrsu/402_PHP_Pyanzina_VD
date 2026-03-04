@extends('layouts.app')

@section('content')
<h2>Игра #{{ $game->id }}</h2>
<p class="mb-12"><strong>Игрок:</strong> {{ $game->player_name }}</p>
<p class="mb-12"><strong>Дата:</strong> {{ $game->created_at->format('d.m.Y H:i') }}</p>
<p class="mb-12"><strong>Результат:</strong> {{ $game->correct_answers }} / {{ $game->total_questions }}</p>

@if ($game->steps->isEmpty())
<p class="empty-msg center">Нет ходов</p>
@else
<table>
    <thead>
        <tr>
            <th>№</th>
            <th>Число 1</th>
            <th>Число 2</th>
            <th>НОД</th>
            <th>Ответ</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($game->steps as $step)
        <tr>
            <td>{{ $step->step_number }}</td>
            <td>{{ $step->number1 }}</td>
            <td>{{ $step->number2 }}</td>
            <td>{{ $step->correct_answer }}</td>
            <td>{{ $step->player_answer }}</td>
            <td>{{ $step->is_correct ? '✅' : '❌' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<div class="center mt-10">
    <a href="{{ route('games') }}" class="btn btn-secondary">← К списку</a>
    <a href="{{ route('home') }}" class="btn btn-gray">На главную</a>
</div>
@endsection