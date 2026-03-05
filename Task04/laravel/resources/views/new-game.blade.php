@extends('layouts.app')

@section('content')
<h2>Новая игра</h2>
<form action="{{ route('start-game') }}" method="POST">
    @csrf
    <label for="player_name">Имя игрока</label>
    <input type="text" id="player_name" name="player_name" placeholder="Введите имя" required autofocus>
    <div class="center mt-10">
        <button type="submit" class="btn btn-primary">Начать</button>
        <a href="{{ route('home') }}" class="btn btn-gray">Назад</a>
    </div>
</form>
@endsection