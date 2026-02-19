@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6" style="max-width: 500px; margin: 0 auto;">
            <div class="card">
                <h1 class="text-center">Вход в систему</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="remember" style="width: auto;"> Запомнить меня
                        </label>
                    </div>

                    <button type="submit" class="btn" style="width: 100%;">Войти</button>
                </form>

                <hr>
                <p class="text-center">
                    Нет аккаунта? <a href="{{ route('register') }}" style="color: #C3B1E1;">Зарегистрироваться</a>
                </p>
            </div>
        </div>
    </div>
@endsection