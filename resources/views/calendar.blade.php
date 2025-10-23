<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Ежедневное расписание </title>
    @include('partials.head')

    <!-- Стили страницы Calendar -->
    @vite(['resources/css/calendar.css', 'resources/js/calendar.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <div class="container calendar-container">
            <h1 class="calendar-title">Расписание богослужений и мероприятий</h1>
            <div id="calendar"></div>
        </div>
    </main>

    @include('partials.footer')

    @include('partials.scripts')

    <script></script>
</body>

</html>
