@extends('layouts.app')

@section('title', 'Создание подачи')

@section('content')
    <div class="card">
        <h1>Создание новой подачи</h1>

        <form method="POST" action="{{ route('submissions.store') }}">
            @csrf

            <div class="form-group">
                <label for="contest_id">Конкурс</label>
                <select name="contest_id" id="contest_id" required>
                    <option value="">Выберите конкурс</option>
                    @foreach($contests as $contest)
                        <option value="{{ $contest->id }}" {{ old('contest_id') == $contest->id ? 'selected' : '' }}>
                            {{ $contest->title }} (до {{ $contest->deadline_at->format('d.m.Y') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title">Название работы</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Описание работы</label>
                <textarea name="description" id="description" rows="5">{{ old('description') }}</textarea>
            </div>

            <div class="flex">
                <button type="submit" class="btn">Создать черновик</button>
                <a href="{{ route('submissions.index') }}" class="btn btn-beige">Отмена</a>
            </div>
        </form>
    </div>
@endsection