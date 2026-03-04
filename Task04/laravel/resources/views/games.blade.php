@extends('layouts.app')

@section('content')
<h2>История игр</h2>

@if ($games->isEmpty())
<p class="empty-msg center">Пока нет сохранённых игр</p>
@else
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Игрок</th>
            <th>Дата</th>
            <th>Результат</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($games as $game)
        <tr>
            <td><a class="link" href="{{ route('game-details', $game->id) }}">{{ $game->id }}</a></td>
            <td>{{ $game->player_name }}</td>
            <td>{{ $game->created_at->format('d.m.Y H:i') }}</td>
            <td>{{ $game->correct_answers }} / {{ $game->total_questions }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<div class="center mt-10">
    <a href="{{ route('home') }}" class="btn btn-gray">На главную</a>
</div>
@endsection