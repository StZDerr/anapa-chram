<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Фотогалерея - Храм святого князя Владимира в Анапе</title>
    @include('partials.head')

    <!-- PhotoSwipe v5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe.css" />

    <!-- Стили страницы Gallery -->
    @vite(['resources/css/gallery.css', 'resources/js/gallery.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <div class="container py-5">
            <div class="photo-section">
                <h1 class="text-center title mb-4">ФОТОГАЛЕРЕЯ</h1>

                <!-- Фильтры категорий -->
                <div class="photo-filters d-flex justify-content-center gap-3 mb-5">
                    <button class="btn btn-filter active" data-target="#gallery-temple">Храм</button>
                    <button class="btn btn-filter" data-target="#gallery-festivals">Праздники</button>
                    <button class="btn btn-filter" data-target="#gallery-park">Крещенский парк</button>
                </div>

                <!-- Галереи: сетка изображений -->
                <div class="gallery-wrap">
                    <!-- Храм -->
                    <div id="gallery-temple" class="gallery-instance">
                        <div class="gallery-grid">
                            <a href="{{ asset('images/ChramSvitogo.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/ChramSvitogo.jpg') }}" alt="Храм">
                            </a>
                            <a href="{{ asset('images/galery.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/galery.jpg') }}" alt="Интерьер">
                            </a>
                            <a href="{{ asset('images/Duhovenstvo.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/Duhovenstvo.jpg') }}" alt="Духовенство">
                            </a>
                            <a href="{{ asset('images/Popechiteli.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/Popechiteli.jpg') }}" alt="Попечители">
                            </a>
                            <a href="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}" class="gallery-item"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}" alt="Купель">
                            </a>
                            <a href="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}" class="gallery-item"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}" alt="Икона">
                            </a>
                            <a href="{{ asset('images/ChramSvitogo.jpg') }}" class="gallery-item"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/ChramSvitogo.jpg') }}" alt="Храм">
                            </a>
                            <a href="{{ asset('images/galery.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/galery.jpg') }}" alt="Интерьер">
                            </a>
                            <a href="{{ asset('images/Duhovenstvo.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/Duhovenstvo.jpg') }}" alt="Духовенство">
                            </a>
                        </div>
                    </div>

                    <!-- Праздники -->
                    <div id="gallery-festivals" class="gallery-instance d-none">
                        <div class="gallery-grid">
                            <a href="{{ asset('images/newsOne.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/newsOne.jpg') }}" alt="Праздник">
                            </a>
                            <a href="{{ asset('images/activity.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/activity.jpg') }}" alt="Праздник 2">
                            </a>
                            <a href="{{ asset('images/newsOne.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/newsOne.jpg') }}" alt="Праздник 3">
                            </a>
                            <a href="{{ asset('images/activity.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/activity.jpg') }}" alt="Праздник 4">
                            </a>
                            <a href="{{ asset('images/newsOne.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/newsOne.jpg') }}" alt="Праздник 5">
                            </a>
                            <a href="{{ asset('images/activity.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/activity.jpg') }}" alt="Праздник 6">
                            </a>
                            <a href="{{ asset('images/newsOne.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/newsOne.jpg') }}" alt="Праздник 7">
                            </a>
                            <a href="{{ asset('images/activity.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/activity.jpg') }}" alt="Праздник 8">
                            </a>
                            <a href="{{ asset('images/newsOne.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/newsOne.jpg') }}" alt="Праздник 9">
                            </a>
                        </div>
                    </div>

                    <!-- Крещенский парк -->
                    <div id="gallery-park" class="gallery-instance d-none">
                        <div class="gallery-grid">
                            <a href="{{ asset('images/ChramSvitogo.jpg') }}" class="gallery-item"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/ChramSvitogo.jpg') }}" alt="Парк">
                            </a>
                            <a href="{{ asset('images/galery.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/galery.jpg') }}" alt="Парк 2">
                            </a>
                            <a href="{{ asset('images/Duhovenstvo.jpg') }}" class="gallery-item"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/Duhovenstvo.jpg') }}" alt="Парк 3">
                            </a>
                            <a href="{{ asset('images/Popechiteli.jpg') }}" class="gallery-item"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/Popechiteli.jpg') }}" alt="Парк 4">
                            </a>
                            <a href="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}" class="gallery-item"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}" alt="Парк 5">
                            </a>
                            <a href="{{ asset('images/ChramSvitogo.jpg') }}" class="gallery-item"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/ChramSvitogo.jpg') }}" alt="Парк 6">
                            </a>
                            <a href="{{ asset('images/galery.jpg') }}" class="gallery-item" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/galery.jpg') }}" alt="Парк 7">
                            </a>
                            <a href="{{ asset('images/Duhovenstvo.jpg') }}" class="gallery-item"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/Duhovenstvo.jpg') }}" alt="Парк 8">
                            </a>
                            <a href="{{ asset('images/Popechiteli.jpg') }}" class="gallery-item"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/Popechiteli.jpg') }}" alt="Парк 9">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    @include('partials.scripts')

    <!-- PhotoSwipe v5 JS (Core + Lightbox) -->
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/umd/photoswipe.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/umd/photoswipe-lightbox.umd.min.js"></script>
</body>

</html>
