<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Новости и события - Храм святого князя Владимира в Анапе</title>
    @include('partials.head')

    <!-- Стили страницы News -->
    @vite(['resources/css/news.css'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <div class="news-page">
            <div class="container py-5">
                <h1 class="title text-center mb-5">НОВОСТИ И СОБЫТИЯ</h1>
                <div class="news-grid">
                    <!-- Карточка 1 -->
                    <div class="news-card">
                        <div class="news-card-image">
                            <img src="{{ asset('images/newsOne.jpg') }}" alt="История Храма">
                        </div>
                        <div class="news-card-body">
                            <h3 class="news-card-title">История Храма</h3>
                            <p class="news-card-description">
                                Сегодня Церковь празднует память отцов Первого Вселенского собора
                            </p>
                            <a href="{{ route('test') }}" class="news-btn">Читать</a>
                        </div>
                    </div>

                    <!-- Карточка 2 -->
                    <div class="news-card">
                        <div class="news-card-image">
                            <img src="{{ asset('images/newsOne.jpg') }}" alt="Крещенский парк">
                        </div>
                        <div class="news-card-body">
                            <h3 class="news-card-title">Крещенский парк</h3>
                            <p class="news-card-description">
                                Сегодня Церковь празднует память отцов Первого Вселенского собора
                            </p>
                            <a href="#" class="news-btn">Читать</a>
                        </div>
                    </div>

                    <!-- Карточка 3 -->
                    <div class="news-card">
                        <div class="news-card-image">
                            <img src="{{ asset('images/newsOne.jpg') }}" alt="Вербное воскресенье">
                        </div>
                        <div class="news-card-body">
                            <h3 class="news-card-title">Вербное воскресенье</h3>
                            <p class="news-card-description">
                                Сегодня Церковь празднует память отцов Первого Вселенского собора
                            </p>
                            <a href="#" class="news-btn">Читать</a>
                        </div>
                    </div>

                    <!-- Карточка 4 -->
                    <div class="news-card">
                        <div class="news-card-image">
                            <img src="{{ asset('images/newsOne.jpg') }}" alt="История Храма">
                        </div>
                        <div class="news-card-body">
                            <h3 class="news-card-title">История Храма</h3>
                            <p class="news-card-description">
                                Сегодня Церковь празднует память отцов Первого Вселенского собора
                            </p>
                            <a href="#" class="news-btn">Читать</a>
                        </div>
                    </div>

                    <!-- Карточка 5 -->
                    <div class="news-card">
                        <div class="news-card-image">
                            <img src="{{ asset('images/newsOne.jpg') }}" alt="Крещенский парк">
                        </div>
                        <div class="news-card-body">
                            <h3 class="news-card-title">Крещенский парк</h3>
                            <p class="news-card-description">
                                Сегодня Церковь празднует память отцов Первого Вселенского собора
                            </p>
                            <a href="#" class="news-btn">Читать</a>
                        </div>
                    </div>

                    <!-- Карточка 6 -->
                    <div class="news-card">
                        <div class="news-card-image">
                            <img src="{{ asset('images/newsOne.jpg') }}" alt="Вербное воскресенье">
                        </div>
                        <div class="news-card-body">
                            <h3 class="news-card-title">Вербное воскресенье</h3>
                            <p class="news-card-description">
                                Сегодня Церковь празднует память отцов Первого Вселенского собора
                            </p>
                            <a href="#" class="news-btn">Читать</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    @include('partials.scripts')
</body>

</html>
