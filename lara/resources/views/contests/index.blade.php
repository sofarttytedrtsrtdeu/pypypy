@extends('layouts.app')

@section('title', 'Управление конкурсами')

@section('content')
    <div class="flex justify-between align-center mb-20">
        <h1>Конкурсы</h1>
        <a href="{{ route('admin.contests.create') }}" class="btn">Создать конкурс</a>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Дедлайн</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contests as $contest)
                    <tr>
                        <td>{{ $contest->id }}</td>
                        <td>{{ $contest->title }}</td>
                        <td>{{ $contest->deadline_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <span class="status-badge {{ $contest->is_active ? 'status-accepted' : 'status-rejected' }}">
                                {{ $contest->is_active ? 'Активен' : 'Неактивен' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.contests.edit', $contest) }}" class="btn btn-small">Редактировать</a>
                            <form method="POST" action="{{ route('admin.contests.destroy', $contest) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-small btn-beige" onclick="return confirm('Удалить конкурс?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Конкурсы не найдены</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $contests->links() }}
        </div>
    </div>
@endsection