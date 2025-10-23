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
    @vite(['resources/css/temple.css', 'resources/css/donation-modal.css', 'resources/js/temple.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <div class="container py-5">
            <h1 class="text-center temple-title mb-5">
                Храм святого равноапостольного
                великого князя Владимира
            </h1>

            <!-- Основной контент -->
            <div class="temple-content">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class="swiper-container-wrapper">
                            <!-- Большое изображение -->
                            <div class="swiper gallery-top">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/ChramSvitogo.jpg') }}"
                                            alt="Храм святого князя Владимира">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}"
                                            alt="Храм святого князя Владимира">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/galery.jpg') }}" alt="Храм святого князя Владимира">
                                    </div>
                                </div>

                                <!-- Стрелки -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>

                            <!-- Превью (миниатюры) -->
                            <div class="swiper gallery-thumbs">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/ChramSvitogo.jpg') }}"
                                            alt="Храм святого князя Владимира">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}"
                                            alt="Храм святого князя Владимира">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/galery.jpg') }}" alt="Храм святого князя Владимира">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="title">О храме</div>
                        <div class="details fs-6">
                            Горожане с нетерпением ждали долгожданное открытие Крещенского парка в
                            Анапе и уже его посетили, а вот новые жители города не знают, где именно он находится и как
                            сюда можно добраться.
                            Проходя храм мы попадаем на огромную площадь с фонтанами, вымощенную крупной плиткой. Место
                            поистине огромно. На мой взгляд больше площади у "Родины". Фонтан работал только при
                            освящений храма, уже сегодня его доводят до ума мастера. По всей площади большое количество
                            диодных фонарей и точечных спотов. Вечером тут светло.
                            Проходя храм мы попадаем на огромную площадь с фонтанами, вымощенную крупной плиткой. Место
                            поистине огромно. На мой взгляд больше площади у "Родины". Фонтан работал только при
                            освящений храма, уже сегодня его доводят до ума мастера. По всей площади большое количество
                            диодных фонарей и точечных спотов. Вечером тут светло. Анапе и уже его посетили, а вот новые
                            жители города не знают, где именно он находится и как сюда можно добраться
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class="title">Открытие храма</div>
                        <div class="details fs-6">
                            1 октября 2023 года состоялось открытие Храма Святого равноапостольного Великого князя
                            Владимира
                        </div>
                        <div class="more-details fs-6">
                            Патриарх Московский и всея Руси Кирилл освятил храм в честь святого равноапостольного князя
                            Владимира в городе-курорте Анапа. В ходе мероприятия патриарх подарил храму образ Святой
                            Матроны Московской.
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="swiper-container-wrapper">
                            <!-- Большое изображение (второй свайпер) -->
                            <div class="swiper gallery-top-2">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/ChramSvitogo.jpg') }}"
                                            alt="Храм святого князя Владимира">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}"
                                            alt="Храм святого князя Владимира">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/galery.jpg') }}" alt="Храм святого князя Владимира">
                                    </div>
                                </div>

                                <!-- Стрелки -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>

                            <!-- Превью (миниатюры второго свайпера) -->
                            <div class="swiper gallery-thumbs-2">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/ChramSvitogo.jpg') }}"
                                            alt="Храм святого князя Владимира">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}"
                                            alt="Храм святого князя Владимира">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/galery.jpg') }}" alt="Храм святого князя Владимира">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clergy">
            <div class="container">
                <div class="title text-center">ДУХОВЕНСТВО ХРАМА</div>
                <div class="details">Священнослужители, постоянно служащие в нашем храме</div>
                <div class="clergy-cards">
                    <div class="row g-4">
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="clergy-card">
                                <img src="{{ asset('images/personal/frame-30.webp') }}" alt="Духовенство">
                                <div class="card-name">Имя Фамилия</div>
                                <div class="card-position">должность</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="clergy-card">
                                <img src="{{ asset('images/personal/frame-28.webp') }}" alt="Духовенство">
                                <div class="card-name">Имя Фамилия</div>
                                <div class="card-position">должность</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="clergy-card">
                                <img src="{{ asset('images/personal/izobrazhenie-whatsapp-2025-01-20-v-17.46.27_6aa9051f.webp') }}"
                                    alt="Духовенство">
                                <div class="card-name">Имя Фамилия</div>
                                <div class="card-position">должность</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="clergy-card">
                                <img src="{{ asset('images/personal/izobrazhenie-whatsapp-2025-01-24-v-15.29.38_dfe7e4f6.webp') }}"
                                    alt="Духовенство">
                                <div class="card-name">Имя Фамилия</div>
                                <div class="card-position">должность</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="title text-center mt-5">ПЕРСОНАЛ ХРАМА</div>
                <div class="details">Работающих на приходе</div>
                <div class="clergy-cards">
                    <div class="row g-4">
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="clergy-card">
                                <img src="{{ asset('images/personal/frame-30.webp') }}" alt="Духовенство">
                                <div class="card-name">Имя Фамилия</div>
                                <div class="card-position">должность</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="clergy-card">
                                <img src="{{ asset('images/personal/frame-28.webp') }}" alt="Духовенство">
                                <div class="card-name">Имя Фамилия</div>
                                <div class="card-position">должность</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="clergy-card">
                                <img src="{{ asset('images/personal/izobrazhenie-whatsapp-2025-01-20-v-17.46.27_6aa9051f.webp') }}"
                                    alt="Духовенство">
                                <div class="card-name">Имя Фамилия</div>
                                <div class="card-position">должность</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="clergy-card">
                                <img src="{{ asset('images/personal/izobrazhenie-whatsapp-2025-01-24-v-15.29.38_dfe7e4f6.webp') }}"
                                    alt="Духовенство">
                                <div class="card-name">Имя Фамилия</div>
                                <div class="card-position">должность</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="activity">
                <div class="text-center title">ДЕЯТЕЛЬНОСТЬ ХРАМА</div>

                <!-- Второй Swiper с pagination -->
                <div class="activity-swiper-container">
                    <div class="swiper-wrapper">
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="activity-slide-inner">
                                <img src="{{ asset('images/activity.jpg') }}" alt="Деятельность храма"
                                    class="activity-slide-img">
                                <div class="activity-slide-overlay">
                                    <div class="activity-slide-title">Воскресная школа</div>
                                    <div class="activity-slide-desc">Обучение детей основам православной веры и
                                        культуры
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="swiper-slide">
                            <div class="activity-slide-inner">
                                <img src="{{ asset('images/activity.jpg') }}" alt="Деятельность храма"
                                    class="activity-slide-img">
                                <div class="activity-slide-overlay">
                                    <div class="activity-slide-title">Благотворительность</div>
                                    <div class="activity-slide-desc">Помощь нуждающимся и социальная поддержка</div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="swiper-slide">
                            <div class="activity-slide-inner">
                                <img src="{{ asset('images/activity.jpg') }}" alt="Деятельность храма"
                                    class="activity-slide-img">
                                <div class="activity-slide-overlay">
                                    <div class="activity-slide-title">Паломничество</div>
                                    <div class="activity-slide-desc">Организация поездок по святым местам</div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 4 -->
                        <div class="swiper-slide">
                            <div class="activity-slide-inner">
                                <img src="{{ asset('images/activity.jpg') }}" alt="Деятельность храма"
                                    class="activity-slide-img">
                                <div class="activity-slide-overlay">
                                    <div class="activity-slide-title">Молодежное движение</div>
                                    <div class="activity-slide-desc">Встречи и мероприятия для молодежи</div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 5 -->
                        <div class="swiper-slide">
                            <div class="activity-slide-inner">
                                <img src="{{ asset('images/activity.jpg') }}" alt="Деятельность храма"
                                    class="activity-slide-img">
                                <div class="activity-slide-overlay">
                                    <div class="activity-slide-title">Хор и клирос</div>
                                    <div class="activity-slide-desc">Церковное пение и богослужения</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination (точки) -->
                    <div class="swiper-pagination activity-pagination"></div>
                </div>
            </div>
        </div>
        <div class="donation">
            <div class="container py-5">
                <div class="text-center title m-4">ПОЖЕРТВОВАНИЕ</div>
                <!-- Hero секция с фотографией храма -->
                <section class="hero-section">
                    <div class="hero-image">
                        <img src="{{ asset('images/donation/donatio-back.webp') }}"
                            alt="Храм святого князя Владимира">
                    </div>
                    <div class="hero-overlay">
                        <div class="hero-content">
                            <div class="hero-logo">
                                <img src="{{ asset('images/logo.svg') }}" alt="Логотип храма">
                            </div>
                            <div class="hero-quote">
                                <p>"ЕСЛИ НА ВАШУ ДОЛЮ ВЫПАЛА ЧЕСТЬ СТРОИТЬ ДОМ БОЖИЙ, ПРИМИТЕ ЭТО КАК ВЕЛИКИЙ ДАР
                                    ТВОРЦА,
                                    ИБО
                                    ДЕСНИЦА ГОСПОДНЯ КАСАЕТСЯ ТОГО, КТО СТРОИТ ХРАМЫ, И МНОГИЕ ГРЕХИ ПРОСТИТ ТОМУ
                                    ГОСПОДЬ."
                                </p>
                                <p class="hero-author">СВЯТОЙ ПРАВЕДНЫЙ ИОАНН КРОНШТАДСКИЙ</p>
                            </div>
                            <button class="hero-btn" data-bs-toggle="modal"
                                data-bs-target="#donationModal">Пожертвовать</button>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="container mb-5">
            <div class="photo-section">
                <div class="text-center title">ФОТОГАЛЕРЕЯ</div>
                <!-- Фильтры категорий -->
                <div class="photo-filters d-flex justify-content-center gap-3 mb-4">
                    <button class="btn btn-filter active" data-target="#gallery-temple">Храм</button>
                    <button class="btn btn-filter" data-target="#gallery-festivals">Праздники</button>
                    <button class="btn btn-filter" data-target="#gallery-park">Крещенский парк</button>
                </div>

                <!-- Галереи: по одному Swiper на категорию -->
                <div class="gallery-wrap">
                    <!-- Храм -->
                    <div id="gallery-temple" class="gallery-instance">
                        <div class="swiper gallery-swiper gallery-temple-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><a href="{{ asset('images/ChramSvitogo.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800">
                                        <img src="{{ asset('images/ChramSvitogo.jpg') }}" alt="Храм">
                                    </a>
                                </div>
                                <div class="swiper-slide"><a href="{{ asset('images/galery.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800">
                                        <img src="{{ asset('images/galery.jpg') }}" alt="Интерьер">
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="{{ asset('images/Duhovenstvo.jpg') }}" data-pswp-width="1200"
                                        data-pswp-height="800">
                                        <img src="{{ asset('images/Duhovenstvo.jpg') }}" alt="Духовенство">
                                    </a>
                                </div>
                                <div class="swiper-slide"><a href="{{ asset('images/Popechiteli.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800">
                                        <img src="{{ asset('images/Popechiteli.jpg') }}" alt="Храм 4">
                                    </a>
                                </div>
                                <div class="swiper-slide"><a
                                        href="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800">
                                        <img src="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}" alt="Купель">
                                    </a>
                                </div>
                                <div class="swiper-slide"><a
                                        href="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800">
                                        <img src="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}"
                                            alt="Икона">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Кнопки навигации для Храм -->
                        <div class="swiper-button-prev gallery-temple-prev"></div>
                        <div class="swiper-button-next gallery-temple-next"></div>
                    </div>

                    <!-- Праздники -->
                    <div id="gallery-festivals" class="gallery-instance d-none">
                        <div class="swiper gallery-swiper gallery-festivals-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><a href="{{ asset('images/newsOne.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800">
                                        <img src="{{ asset('images/newsOne.jpg') }}" alt="Праздник">
                                    </a>
                                </div>
                                <div class="swiper-slide"><a href="{{ asset('images/activity.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800">
                                        <img src="{{ asset('images/activity.jpg') }}" alt="Праздник 2">
                                    </a>
                                </div>
                                <div class="swiper-slide"><a href="{{ asset('images/newsOne.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800">
                                        <img src="{{ asset('images/newsOne.jpg') }}" alt="Праздник 3">
                                    </a>
                                </div>
                                <div class="swiper-slide"><a href="{{ asset('images/activity.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800">
                                        <img src="{{ asset('images/activity.jpg') }}" alt="Праздник 4">
                                    </a>
                                </div>
                                <div class="swiper-slide"><a href="{{ asset('images/newsOne.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800">
                                        <img src="{{ asset('images/newsOne.jpg') }}" alt="Праздник 5">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Кнопки навигации для Праздники -->
                        <div class="swiper-button-prev gallery-festivals-prev"></div>
                        <div class="swiper-button-next gallery-festivals-next"></div>
                    </div>

                    <!-- Крещенский парк -->
                    <div id="gallery-park" class="gallery-instance d-none">
                        <div class="swiper gallery-swiper gallery-park-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><a href="{{ asset('images/ChramSvitogo.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800"><img
                                            src="{{ asset('images/ChramSvitogo.jpg') }}" alt="Парк"></a></div>
                                <div class="swiper-slide"><a href="{{ asset('images/galery.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800"><img
                                            src="{{ asset('images/galery.jpg') }}" alt="Парк 2"></a></div>
                                <div class="swiper-slide"><a href="{{ asset('images/Duhovenstvo.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800"><img
                                            src="{{ asset('images/Duhovenstvo.jpg') }}" alt="Парк 3"></a></div>
                                <div class="swiper-slide"><a href="{{ asset('images/Popechiteli.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800"><img
                                            src="{{ asset('images/Popechiteli.jpg') }}" alt="Парк 4"></a></div>
                                <div class="swiper-slide"><a
                                        href="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}"
                                        data-pswp-width="1200" data-pswp-height="800"><img
                                            src="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}"
                                            alt="Парк 5"></a>
                                </div>
                            </div>
                        </div>
                        <!-- Кнопки навигации для Парк -->
                        <div class="swiper-button-prev gallery-park-prev"></div>
                        <div class="swiper-button-next gallery-park-next"></div>
                    </div>
                </div>
            </div>
        </div>
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
