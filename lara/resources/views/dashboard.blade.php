@extends('layouts.app')

@section('title', 'Дашборд')

@section('content')
    <div class="card">
        <h1>Добро пожаловать, {{ Auth::user()->name }}!</h1>
        <p>Ваша роль: <strong>{{ Auth::user()->role }}</strong></p>
    </div>

    <div class="card">
        <h2>Быстрые действия</h2>
        <div class="flex">
            @if(Auth::user()->role === 'participant')
                <a href="{{ route('submissions.create') }}" class="btn">Создать новую подачу</a>
            @endif
            <a href="{{ route('submissions.index') }}" class="btn btn-beige">Посмотреть все подачи</a>
        </div>
    </div>
@endsection