<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Храм святого князя Владимира - Храм святого князя Владимира в Анапе</title>
    @include('partials.head')

    <!-- PhotoSwipe v5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe.css" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Стили страницы Temple -->
    @vite(['resources/css/app.css', 'resources/css/activity-swiper.css', 'resources/js/activity-swiper.js', 'resources/js/photo-section.js', 'resources/css/temple.css', 'resources/css/donation-modal.css', 'resources/js/temple.js', 'resources/css/photo-section.css', 'resources/css/clergy.css', 'resources/css/donation.css'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <div class="container py-5">
            <h1 class="text-center temple-title mb-5">
                {{ $templePage->title ?? 'Храм святого равноапостольного великого князя Владимира' }}
            </h1>

            <!-- Основной контент -->
            <div class="temple-content">
                <div class="row">
                    <div class="col-sm-12 col-lg-6 d-flex align-items-center">
                        <div class="swiper-container-wrapper w-100 sticky-swiper">
                            <!-- Большое изображение -->
                            <div class="swiper gallery-top">
                                <div class="swiper-wrapper">
                                    @php
                                        $gallery1 = $templePage->gallery_1_images ?? [
                                            'images/ChramSvitogo.jpg',
                                            'images/derzhavnaya_ikona_bozhej_materi.jpg',
                                            'images/galery.jpg',
                                        ];
                                    @endphp
                                    @foreach ($gallery1 as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ asset(str_starts_with($image, 'http') ? $image : 'storage/' . $image) }}"
                                                alt="Храм святого князя Владимира">
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Стрелки -->
                                <div class="swiper-button-prev gallery-top-prev">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <line x1="19" y1="12" x2="5" y2="12"></line>
                                        <polyline points="12 19 5 12 12 5"></polyline>
                                    </svg>
                                </div>
                                <div class="swiper-button-next gallery-top-next">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </div>
                            </div>

                            <!-- Превью (миниатюры) -->
                            <div class="swiper gallery-thumbs">
                                <div class="swiper-wrapper">
                                    @foreach ($gallery1 as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ asset(str_starts_with($image, 'http') ? $image : 'storage/' . $image) }}"
                                                alt="Храм святого князя Владимира">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        {{-- <div class="title">О храме</div> --}}
                        <div class="details fs-5">
                            {!! $templePage->about_text ??
                                'Горожане с нетерпением ждали долгожданное открытие Крещенского парка в Анапе и уже его посетили, а вот новые жители города не знают, где именно он находится и как сюда можно добраться.' !!}
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12 col-lg-6">
                        <div class="title">{{ $templePage->opening_title ?? 'Открытие храма' }}</div>
                        <div class="details fs-5">
                            {!! $templePage->opening_text ??
                                '1 октября 2023 года состоялось открытие Храма Святого равноапостольного Великого князя Владимира' !!}
                        </div>
                        <div class="more-details fs-5">
                            {!! $templePage->opening_details ??
                                'Патриарх Московский и всея Руси Кирилл освятил храм в честь святого равноапостольного князя Владимира в городе-курорте Анапа.' !!}
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6 d-flex align-items-center">
                        <div class="swiper-container-wrapper w-100 sticky-swiper">
                            <!-- Большое изображение (второй свайпер) -->
                            <div class="swiper gallery-top-2">
                                <div class="swiper-wrapper">
                                    @php
                                        $gallery2 = $templePage->gallery_2_images ?? [
                                            'images/ChramSvitogo.jpg',
                                            'images/derzhavnaya_ikona_bozhej_materi.jpg',
                                            'images/galery.jpg',
                                        ];
                                    @endphp
                                    @foreach ($gallery2 as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ asset(str_starts_with($image, 'http') ? $image : 'storage/' . $image) }}"
                                                alt="Храм святого князя Владимира">
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Стрелки -->
                                <div class="swiper-button-prev gallery-top-2-prev">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <line x1="19" y1="12" x2="5" y2="12"></line>
                                        <polyline points="12 19 5 12 12 5"></polyline>
                                    </svg>
                                </div>
                                <div class="swiper-button-next gallery-top-2-next">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </div>
                            </div>

                            <!-- Превью (миниатюры второго свайпера) -->
                            <div class="swiper gallery-thumbs-2">
                                <div class="swiper-wrapper">
                                    @foreach ($gallery2 as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ asset(str_starts_with($image, 'http') ? $image : 'storage/' . $image) }}"
                                                alt="Храм святого князя Владимира">
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('partials.clergy')
        @include('partials.activity-partials')
        @include('partials.donation')

        @include('partials.photo-section')
    </main>

    @include('partials.donation-modal')

    @include('partials.footer')

    @include('partials.scripts')

    <!-- PhotoSwipe v5 JS (Core + Lightbox) -->
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/umd/photoswipe.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/umd/photoswipe-lightbox.umd.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>
