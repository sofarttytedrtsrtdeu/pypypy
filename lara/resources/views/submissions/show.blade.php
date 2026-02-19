@extends('layouts.app')

@section('title', $submission->title)

@section('content')
    <div class="card">
        <div class="flex justify-between align-center">
            <h1>{{ $submission->title }}</h1>
            <span class="status-badge status-{{ $submission->status }}">
                {{ $submission->status }}
            </span>
        </div>

        <p><strong>Конкурс:</strong> {{ $submission->contest->title }}</p>
        <p><strong>Автор:</strong> {{ $submission->user->name }}</p>
        <p><strong>Дата создания:</strong> {{ $submission->created_at->format('d.m.Y H:i') }}</p>

        @if($submission->description)
            <hr>
            <h3>Описание</h3>
            <p>{{ $submission->description }}</p>
        @endif

        @if(Auth::id() === $submission->user_id && in_array($submission->status, ['draft', 'needs_fix']))
            <hr>
            <div class="flex">
                <a href="{{ route('submissions.edit', $submission) }}" class="btn">Редактировать</a>
                
                @if($submission->attachments()->where('status', 'scanned')->exists())
                    <form method="POST" action="{{ route('submissions.submit', $submission) }}">
                        @csrf
                        <button type="submit" class="btn btn-beige">Отправить на проверку</button>
                    </form>
                @endif
            </div>
        @endif

        @if(in_array(Auth::user()->role, ['jury', 'admin']) && $submission->status !== 'draft')
            <hr>
            <h3>Изменить статус</h3>
            <form method="POST" action="{{ route('submissions.change-status', $submission) }}" class="flex">
                @csrf
                @method('PATCH')
                <select name="status" required>
                    <option value="">Выберите статус</option>
                    @if($submission->status === 'submitted')
                        <option value="needs_fix">Требуется доработка</option>
                        <option value="accepted">Принято</option>
                        <option value="rejected">Отклонено</option>
                    @elseif($submission->status === 'needs_fix')
                        <option value="submitted">Отправлено повторно</option>
                        <option value="accepted">Принято</option>
                        <option value="rejected">Отклонено</option>
                    @endif
                </select>
                <button type="submit" class="btn">Изменить</button>
            </form>
        @endif
    </div>

    <div class="card">
        @include('partials.attachments')
    </div>

    <div class="card">
        @include('partials.comments')
    </div>
@endsection