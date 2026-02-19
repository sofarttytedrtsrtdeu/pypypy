@extends('layouts.app')

@section('title', 'Редактирование конкурса')

@section('content')
    <div class="card">
        <h1>Редактирование конкурса</h1>

        <form method="POST" action="{{ route('admin.contests.update', $contest) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Название конкурса</label>
                <input type="text" name="title" id="title" value="{{ old('title', $contest->title) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea name="description" id="description" rows="5">{{ old('description', $contest->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="deadline_at">Дедлайн</label>
                <input type="datetime-local" name="deadline_at" id="deadline_at" value="{{ old('deadline_at', $contest->deadline_at->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $contest->is_active) ? 'checked' : '' }} style="width: auto;">
                    Активен
                </label>
            </div>

            <div class="flex">
                <button type="submit" class="btn">Сохранить</button>
                <a href="{{ route('admin.contests.index') }}" class="btn btn-beige">Отмена</a>
            </div>
        </form>
    </div>
@endsection