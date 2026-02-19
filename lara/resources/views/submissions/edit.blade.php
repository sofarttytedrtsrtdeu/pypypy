@extends('layouts.app')

@section('title', 'Редактирование подачи')

@section('content')
    <div class="card">
        <h1>Редактирование подачи</h1>

        <form method="POST" action="{{ route('submissions.update', $submission) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Название работы</label>
                <input type="text" name="title" id="title" value="{{ old('title', $submission->title) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Описание работы</label>
                <textarea name="description" id="description" rows="5">{{ old('description', $submission->description) }}</textarea>
            </div>

            <div class="flex">
                <button type="submit" class="btn">Сохранить</button>
                <a href="{{ route('submissions.show', $submission) }}" class="btn btn-beige">Отмена</a>
            </div>
        </form>
    </div>
@endsection