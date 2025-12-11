<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.seo')
    @include('partials.head')

    <!-- Стили страницы Zapiski -->
    @vite(['resources/css/app.css', 'resources/css/clergy.css'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        @include('partials.clergy')
    </main>

    @include('partials.footer')

    @include('partials.scripts')
</body>

</html>
