<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.seo')
    @include('partials.head')

    <!-- Стили и скрипты главной страницы (loader + welcome) -->
    @vite(['resources/js/photo-section.js', 'resources/css/calendar-swiper.css', 'resources/js/calendar-swiper.js', 'resources/css/activity-swiper.css', 'resources/js/activity-swiper.js', 'resources/css/loader.css', 'resources/css/welcome.css', 'resources/js/loader.js', 'resources/js/welcome.js', 'resources/css/photo-section.css', 'resources/css/news-swiper.css', 'resources/js/news-swiper.js', 'resources/css/park-swiper.css', 'resources/css/quick.css', 'resources/css/contact.css', 'resources/css/timetable.css'])
</head>

<body class="d-flex flex-column min-vh-100 font-sans antialiased">
    @include('partials.navbar')
    <div class="container">
        <div class="background-container">
            <div class="windows">
                <div class="window" style="background-image: url('{{ asset('images/image-background.webp') }}')"></div>
                <div class="window" style="background-image: url('{{ asset('images/image-background.webp') }}')"></div>
                <div class="window" style="background-image: url('{{ asset('images/image-background.webp') }}')"></div>
                <div class="window" style="background-image: url('{{ asset('images/image-background.webp') }}')"></div>
            </div>
        </div>

        <div class="main-text-block">
            <div class="display-1 display-xl-1 display-lg-2 display-md-3 display-sm-4 fs-0">ХРАМ СВЯТОГО</div>
            <div class="display-1 display-xl-1 display-lg-2 display-md-3 display-sm-4 fs-0">РАВНОАПОСТОЛЬНОГО</div>
            <div class="display-1 display-xl-1 display-lg-2 display-md-3 display-sm-4 fs-0">ВЕЛИКОГО КНЯЗЯ ВЛАДИМИРА
            </div>
            <p>Храм расположен в живописном месте, недалеко от моря, и часто посещается туристами. Парк "Долина Славы" и
                набережная — идеально для прогулки после посещения.</p>
        </div>
    </div>
    @include('partials.calendar-partials')
    @include('partials.quick-partials')
    @include('partials.timetable-partials')
    @include('partials.news-partials')
    @include('partials.activity-partials')

    @include('partials.park-partials')

    @include('partials.photo-section')

    @include('partials.contacts-partials')



    @include('partials.footer')

    @include('partials.scripts')
</body>

</html>
