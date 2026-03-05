@extends('layouts.app')

@section('content')
<p class="subtitle">Найдите наибольший общий делитель двух чисел!</p>
<div class="center">
    <a href="{{ route('new-game') }}" class="btn btn-primary">🎮 Новая игра</a>
    <a href="{{ route('games') }}" class="btn btn-secondary">📋 История игр</a>
</div>
@endsection