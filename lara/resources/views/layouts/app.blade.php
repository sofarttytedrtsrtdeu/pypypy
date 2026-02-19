<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Платформа конкурсов')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #2F2F2F;
            color: #F5F5DC;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        nav {
            background-color: #3a3a3a;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #C3B1E1;
        }

        .nav-left a, .nav-right a {
            color: #C3B1E1;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-left a:hover, .nav-right a:hover {
            color: #F5F5DC;
            text-decoration: none;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-name {
            color: #F5F5DC;
            margin-right: 15px;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #C3B1E1;
            color: #2F2F2F;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(195, 177, 225, 0.2);
        }

        .btn:hover {
            background-color: #d4c4f0;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(195, 177, 225, 0.3);
        }

        .btn-beige {
            background-color: #F5F5DC;
            color: #2F2F2F;
        }

        .btn-beige:hover {
            background-color: #fffff0;
        }

        .btn-small {
            padding: 4px 12px;
            font-size: 12px;
        }

        .card {
            background-color: #3a3a3a;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            border: 1px solid #4a4a4a;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #C3B1E1;
            font-weight: 500;
            font-size: 14px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #4a4a4a;
            border-radius: 8px;
            background-color: #2F2F2F;
            color: #F5F5DC;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #C3B1E1;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #4CAF50;
            color: white;
            border-left: 4px solid #2e7d32;
        }

        .alert-error {
            background-color: #f44336;
            color: white;
            border-left: 4px solid #b71c1c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #3a3a3a;
            border-radius: 12px;
            overflow: hidden;
        }

        th {
            background-color: #4a4a4a;
            color: #C3B1E1;
            font-weight: 600;
            padding: 15px;
            text-align: left;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #4a4a4a;
            color: #F5F5DC;
        }

        tr:hover {
            background-color: #404040;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-draft { background-color: #6c757d; color: white; }
        .status-submitted { background-color: #007bff; color: white; }
        .status-needs_fix { background-color: #ffc107; color: #2F2F2F; }
        .status-accepted { background-color: #28a745; color: white; }
        .status-rejected { background-color: #dc3545; color: white; }
        .status-pending { background-color: #6c757d; color: white; }
        .status-scanned { background-color: #28a745; color: white; }
        .status-rejected { background-color: #dc3545; color: white; }

        .comment {
            background-color: #404040;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 3px solid #C3B1E1;
        }

        .comment-meta {
            color: #C3B1E1;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .comment-body {
            color: #F5F5DC;
        }

        .attachment-item {
            background-color: #404040;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            background-color: #3a3a3a;
            color: #C3B1E1;
            text-decoration: none;
            border-radius: 6px;
            border: 1px solid #4a4a4a;
        }

        .pagination a:hover {
            background-color: #4a4a4a;
        }

        .pagination .active {
            background-color: #C3B1E1;
            color: #2F2F2F;
            border-color: #C3B1E1;
        }

        h1, h2, h3 {
            color: #C3B1E1;
            margin-bottom: 20px;
        }

        hr {
            border: none;
            border-top: 2px solid #4a4a4a;
            margin: 20px 0;
        }

        .text-center { text-align: center; }
        .mt-20 { margin-top: 20px; }
        .mb-20 { margin-bottom: 20px; }
        .flex { display: flex; gap: 10px; }
        .justify-between { justify-content: space-between; }
        .align-center { align-items: center; }
    </style>
</head>
<body>
    <nav>
        <div class="nav-left">
            <a href="{{ route('dashboard') }}">Главная</a>
            @auth
                <a href="{{ route('submissions.index') }}">Подачи</a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.contests.index') }}">Конкурсы</a>
                    <a href="{{ route('admin.users.index') }}">Пользователи</a>
                @endif
            @endauth
        </div>
        <div class="nav-right">
            @auth
                <span class="user-name">{{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-beige">Выйти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn">Вход</a>
                <a href="{{ route('register') }}" class="btn btn-beige">Регистрация</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="list-style: none; padding-left: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>