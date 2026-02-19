@extends('layouts.app')

@section('title', 'Редактирование пользователя')

@section('content')
    <div class="card">
        <h1>Редактирование пользователя: {{ $user->name }}</h1>

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label for="role">Роль</label>
                <select name="role" id="role" required>
                    <option value="participant" {{ old('role', $user->role) == 'participant' ? 'selected' : '' }}>Участник</option>
                    <option value="jury" {{ old('role', $user->role) == 'jury' ? 'selected' : '' }}>Жюри</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Администратор</option>
                </select>
            </div>

            <div class="flex">
                <button type="submit" class="btn">Сохранить</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-beige">Отмена</a>
            </div>
        </form>
    </div>
@endsection