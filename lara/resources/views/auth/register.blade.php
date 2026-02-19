@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6" style="max-width: 500px; margin: 0 auto;">
            <div class="card">
                <h1 class="text-center">Регистрация</h1>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Подтверждение пароля</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn" style="width: 100%;">Зарегистрироваться</button>
                </form>

                <hr>
                <p class="text-center">
                    Уже есть аккаунт? <a href="{{ route('login') }}" style="color: #C3B1E1;">Войти</a>
                </p>
            </div>
        </div>
    </div>
@endsection