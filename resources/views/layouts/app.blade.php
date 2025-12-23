<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Анапа-Храм') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('styles')
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
                            <i class="bi bi-people"></i>
                            Пользователи
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#contentSubmenu" data-bs-toggle="collapse" class="nav-link text-white">
                            <i class="bi bi-file-earmark-text"></i>
                            Контент
                        </a>
                        <ul class="collapse list-unstyled ps-3" id="contentSubmenu">
                            <li><a href="{{ route('admin.news.index') }}" class="nav-link text-white"><i
                                        class="bi bi-newspaper"></i> Новости</a></li>
                            <li><a href="{{ route('admin.activity.index') }}" class="nav-link text-white"><i
                                        class="bi bi-briefcase"></i> Деятельность</a></li>
                            <li><a href="{{ route('admin.events.index') }}" class="nav-link text-white"><i
                                        class="bi bi-calendar-event"></i> Календарь событий</a></li>
                            <li><a href="{{ route('admin.orthodox_calendar.index') }}" class="nav-link text-white"><i
                                        class="bi bi-journal-bookmark"></i> Православный Календарь</a></li>
                            <li><a href="{{ route('admin.gallery.index') }}" class="nav-link text-white"><i
                                        class="bi bi-images"></i> Галерея</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#templeSubmenu" data-bs-toggle="collapse" class="nav-link text-white">
                            <i class="bi bi-bank2"></i>
                            Храмы и иконы
                        </a>
                        <ul class="collapse list-unstyled ps-3" id="templeSubmenu">
                            <li>
                                <a href="{{ route('admin.temple.edit') }}" class="nav-link text-white">
                                    <i class="bi bi-bank2"></i> Храм святого князя Владимира
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.temple.kupelOlgi.edit') }}" class="nav-link text-white">
                                    <i class="bi bi-droplet"></i> Храм-купель святой княгини Ольги
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.temple.derzhavnayaIkona.edit') }}" class="nav-link text-white">
                                    <i class="bi bi-award"></i> Державная икона Божией Матери
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.clergy.index') }}" class="nav-link text-white">
                                    <i class="bi bi-person-badge"></i> Служители храма
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.content-blocks.index') }}" class="nav-link text-white">
                                    <i class="bi bi-person-badge"></i> Требы и пожертвования
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.park.index') }}" class="nav-link text-white">
                            <i class="bi bi-tree"></i>
                            Парк
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#parkSubmenu" data-bs-toggle="collapse" class="nav-link text-white">
                            <i class="bi bi-map"></i>
                            Парк и достопримечательности
                        </a>
                        <ul class="collapse list-unstyled ps-3" id="parkSubmenu">
                            <li><a href="{{ route('admin.attractions.index') }}" class="nav-link text-white"><i
                                        class="bi bi-geo-alt"></i> Достопримечательности</a></li>
                            <li><a href="{{ route('admin.temple-construction.index') }}" class="nav-link text-white"><i
                                        class="bi bi-building"></i> Строительство храма</a></li>
                            <li><a href="{{ route('admin.park-rules.index') }}" class="nav-link text-white"><i
                                        class="bi bi-shield-check"></i> Правила храма</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.seo-settings.index') }}" class="nav-link text-white">
                            <i class="bi bi-gear"></i>
                            SEO
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    @stack('scripts')
</body>

</html>
