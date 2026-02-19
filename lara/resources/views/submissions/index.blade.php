@extends('layouts.app')

@section('title', 'Подачи')

@section('content')
    <div class="flex justify-between align-center mb-20">
        <h1>Подачи на конкурсы</h1>
        @if(Auth::user()->role === 'participant')
            <a href="{{ route('submissions.create') }}" class="btn">Создать подачу</a>
        @endif
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Конкурс</th>
                    <th>Название</th>
                    <th>Автор</th>
                    <th>Статус</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $submission)
                    <tr>
                        <td>{{ $submission->id }}</td>
                        <td>{{ $submission->contest->title }}</td>
                        <td>{{ $submission->title }}</td>
                        <td>{{ $submission->user->name }}</td>
                        <td>
                            <span class="status-badge status-{{ $submission->status }}">
                                {{ $submission->status }}
                            </span>
                        </td>
                        <td>{{ $submission->created_at->format('d.m.Y') }}</td>
                        <td>
                            <a href="{{ route('submissions.show', $submission) }}" class="btn btn-small">Просмотр</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Подачи не найдены</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $submissions->links() }}
        </div>
    </div>
@endsection