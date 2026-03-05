@extends('layouts.app')

@section('content')
<h1>История игр</h1>

@if ($games->isEmpty())
<p>Пока нет сыгранных игр.</p>
@else
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Игрок</th>
            <th>Число 1</th>
            <th>Число 2</th>
            <th>НОД</th>
            <th>Ответ</th>
            <th>Результат</th>
            <th>Дата</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($games as $game)
        <tr>
            <td>{{ $game->id }}</td>
            <td>{{ $game->player_name }}</td>
            <td>{{ $game->number1 }}</td>
            <td>{{ $game->number2 }}</td>
            <td>{{ $game->correct_answer }}</td>
            <td>{{ $game->player_answer }}</td>
            <td>
                @if ($game->is_correct)
                <span class="correct">Верно ✅</span>
                @else
                <span class="incorrect">Неверно ❌</span>
                @endif
            </td>
            <td>{{ $game->created_at->format('d.m.Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection