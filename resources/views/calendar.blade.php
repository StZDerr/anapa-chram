<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.seo')
    @include('partials.head')

    <!-- Стили страницы Calendar -->
    @vite(['resources/css/app.css', 'resources/css/calendar.css', 'resources/css/calendar-swiper.css', 'resources/js/calendar-swiper.js', 'resources/js/calendar.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')



    <main class="flex-fill">

        <div class="container calendar-container">
            <h1 class="calendar-title">ЕЖЕДНЕВНОЕ РАСПИСАНИЕ</h1>

            <!-- Селекторы месяца и года -->
            <div class="calendar-controls">
                <select id="month-select" class="month-select">
                    <option value="0">январь</option>
                    <option value="1">февраль</option>
                    <option value="2">март</option>
                    <option value="3">апрель</option>
                    <option value="4">май</option>
                    <option value="5">июнь</option>
                    <option value="6">июль</option>
                    <option value="7">август</option>
                    <option value="8">сентябрь</option>
                    <option value="9">октябрь</option>
                    <option value="10">ноябрь</option>
                    <option value="11">декабрь</option>
                </select>
                <select id="year-select" class="year-select">
                    <!-- Заполняется динамически через JS -->
                </select>
            </div>

            <div id="calendar"></div>

            <!-- Дублированный блок календарных карточек (перенесён из welcome) -->

        </div>
        @include('partials.calendar-partials')
    </main>

    @include('partials.footer')

    @include('partials.scripts')

    <script></script>
</body>

</html>
