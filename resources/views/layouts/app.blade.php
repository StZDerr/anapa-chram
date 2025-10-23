<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    @auth
        <div id="app" class="d-flex">

            <!-- Sidebar -->
            <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark vh-100" style="width: 280px; position: fixed;">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <svg class="bi pe-none me-2" width="40" height="32" aria-hidden="true">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                    <span class="fs-4">Анапа-Храм</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link text-white">
                            <i class="bi bi-person-circle"></i>
                            Пользователи
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.news.index') }}" class="nav-link text-white">
                            <i class="bi bi-newspaper"></i>
                            Новости
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.activity.index') }}" class="nav-link text-white">
                            <i class="bi bi-building"></i>
                            Деятельность
                        </a>
                    </li>
                </ul>
                <hr>

                <!-- User / Logout -->
                @auth
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/favicon/favicon-32x32-1.png') }}" alt="" width="32"
                                height="32" class="rounded-circle me-2">
                            <strong>{{ Auth::user()->name }}</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                @endauth
            </div>
        @endauth

        <!-- Main content -->
        <main class="flex-grow-1 ms-280" style="margin-left: 280px; padding: 20px;">
            @yield('content')
        </main>

    </div>
</body>
@stack('scripts')

</html>
