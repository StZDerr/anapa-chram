<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Храм святого князя Владимира в Анапе</title>
    @include('partials.head')

    <!-- Стили и скрипты главной страницы (loader + welcome) -->
    @vite(['resources/js/photo-section.js', 'resources/css/calendar-swiper.css', 'resources/js/calendar-swiper.js', 'resources/css/activity-swiper.css', 'resources/js/activity-swiper.js', 'resources/css/loader.css', 'resources/css/welcome.css', 'resources/js/loader.js', 'resources/js/welcome.js', 'resources/css/photo-section.css', 'resources/css/news-swiper.css', 'resources/js/news-swiper.js'])
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
    <div class="container">
        <div class="text-center quick-title">Быстрый доступ</div>
        <div class="quick">
            <div class="div2">
                <a href="{{ route('temple') }}">
                    <div class="quick-card height-fix">
                        <img src="{{ asset('images/ChramSvitogo.jpg') }}" alt="Храм святого князя Владимира">
                        <div class="quick-card-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="quick-card-content">
                            <h3 class="quick-card-title">Храм святого<br>князя Владимира
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="div3">
                <a href="">
                    <div class="quick-card">
                        <img src="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}" alt="Храм-купель княгини Ольги">
                        <div class="quick-card-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="quick-card-content">
                            <h3 class="quick-card-title">Храм-купель<br>княгини Ольги</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="div4">
                <a href="">
                    <div class="quick-card height-fix">
                        <img src="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}"
                            alt="Державная икона Божьей матери">
                        <div class="quick-card-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="quick-card-content">
                            <h3 class="quick-card-title">Державная икона<br>Божьей матери
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="div5">
                <a href="{{ route('gallery') }}">
                    <div class="quick-card">
                        <img src="{{ asset('images/galery.jpg') }}" alt="Галерея">
                        <div class="quick-card-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="quick-card-content">
                            <h3 class="quick-card-title">Галерея</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="div6">
                <a href="">
                    <div class="quick-card height-fix">
                        <img src="{{ asset('images/Duhovenstvo.jpg') }}" alt="Духовенство">
                        <div class="quick-card-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="quick-card-content">
                            <h3 class="quick-card-title">Духовенство</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="div7">
                <a href="">
                    <div class="quick-card">
                        <img src="{{ asset('images/Popechiteli.jpg') }}" alt="Попечители">
                        <div class="quick-card-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="quick-card-content">
                            <h3 class="quick-card-title">Попечители</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="background-color-light-beige mt-5 mb-5">
        <div class="container">
            <div class="timetable mb-3 mt-3">
                <div class="text-center title">
                    ЕЖЕДНЕВНОЕ РАСПИСАНИЕ
                </div>

                @php
                    use Carbon\Carbon;
                    use Illuminate\Support\Str;

                    $today = $today ?? Carbon::today();
                    $startOfWeek = $startOfWeek ?? $today->copy()->startOfWeek(Carbon::MONDAY);
                    $dayNamesFull = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];
                    $dayNamesShort = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
                    // индекс активного дня (0..6) — по ISO (1=Mon..7=Sun)
                    $activeIndex = $today->dayOfWeekIso - 1;
                    $weekEvents = $weekEvents ?? collect();
                @endphp

                <ul class="nav justify-content-center mb-4" id="weekTab" role="tablist">
                    @for ($i = 0; $i < 7; $i++)
                        @php
                            $short = $dayNamesShort[$i];
                            $full = $dayNamesFull[$i];
                            $btnId = Str::slug($short) . '-tab-btn';
                            $paneId = Str::slug($short) . '-tab';
                        @endphp
                        <li class="nav-item" role="presentation">
                            <button class="nav-link day-circle @if ($i === $activeIndex) active @endif"
                                data-short="{{ $short }}" data-full="{{ $full }}"
                                id="{{ $btnId }}" data-bs-toggle="tab" data-bs-target="#{{ $paneId }}"
                                type="button" role="tab" aria-controls="{{ $paneId }}"
                                aria-selected="{{ $i === $activeIndex ? 'true' : 'false' }}">
                                {{ $short }}
                            </button>
                        </li>
                    @endfor
                </ul>

                <div class="tab-content" id="weekTabContent">
                    @for ($i = 0; $i < 7; $i++)
                        @php
                            $dt = $startOfWeek->copy()->addDays($i);
                            $eventsOfDay = $weekEvents->filter(function ($ev) use ($dt) {
                                if (isset($ev->start) && $ev->start instanceof \Carbon\Carbon) {
                                    return $ev->start->isSameDay($dt);
                                }
                                return Str::startsWith((string) $ev->start, $dt->toDateString());
                            });
                            $paneId = Str::slug($dayNamesShort[$i]) . '-tab';
                        @endphp

                        <div class="tab-pane fade @if ($i === $activeIndex) show active @endif"
                            id="{{ $paneId }}" role="tabpanel" aria-labelledby="{{ $btnId }}">
                            <div class="schedule-container">
                                @if ($eventsOfDay->isEmpty())
                                    <div class="schedule-half">
                                        <div class="schedule-text text-muted">Событий нет</div>
                                    </div>
                                @else
                                    @foreach ($eventsOfDay as $ev)
                                        <div class="schedule-half">
                                            <div class="schedule-header">
                                                @php
                                                    $start =
                                                        $ev->start instanceof \Carbon\Carbon
                                                            ? $ev->start
                                                            : \Carbon\Carbon::parse($ev->start);

                                                    $hour = $start->format('H');

                                                    if ($hour >= 5 && $hour < 11) {
                                                        $period = 'Утро';
                                                    } elseif ($hour >= 11 && $hour < 17) {
                                                        $period = 'День';
                                                    } elseif ($hour >= 17 && $hour < 23) {
                                                        $period = 'Вечер';
                                                    } else {
                                                        $period = 'Ночь';
                                                    }
                                                @endphp

                                                <div class="period">
                                                    {{ $period }}
                                                </div>

                                                <div class="time">
                                                    {{ $start->format('H:i') }}
                                                </div>
                                            </div>
                                            <div class="schedule-text">
                                                {{ Str::limit(strip_tags($ev->title), 140) }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>

            </div>
        </div>
    </div>
    @include('partials.news-partials')
    @include('partials.activity-partials')

    <div class="container">
        <div class="gallery-section">
            <div class="text-center title">КРЕЩЕНСКИЙ ПАРК</div>

            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->

                    <div class="swiper-slide active">
                        <img src="{{ asset('images/ChramSvitogo.jpg') }}" alt="Храм святого князя Владимира" />
                        <div class="slide-overlay">
                            <!-- Заголовок с иконкой слева вверху -->
                            <div class="slide-header">
                                <img src="{{ asset('images/Logo2.svg') }}" alt="Логотип" class="slide-icon">
                                <h3 class="slide-title">Крещенский парк</h3>
                            </div>
                            <!-- Описание внизу -->
                            <div class="slide-footer">
                                <p class="slide-description">Горожане с нетерпением ждали долгожданное открытие
                                    Крещенского парка в Анапе и уже его посетили, а вот новые жители города не знают,
                                    где именно он находится и как сюда можно добраться.</p>
                                <a href="{{ route('temple') }}">
                                    <div class="slide-actions">
                                        <span class="slide-link">Узнать больше</span>
                                        <svg class="slide-arrow" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <line x1="5" y1="12" x2="19" y2="12">
                                            </line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <img src="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}" alt="Крещенский парк" />
                        <div class="slide-overlay">
                            <div class="slide-header">
                                <img src="{{ asset('images/Logo2.svg') }}" alt="Логотип" class="slide-icon">
                                <h3 class="slide-title">Крещенский парк</h3>
                            </div>

                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <img src="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}" alt="Крещенский парк" />
                        <div class="slide-overlay">
                            <div class="slide-header">
                                <img src="{{ asset('images/Logo2.svg') }}" alt="Логотип" class="slide-icon">
                                <h3 class="slide-title">Крещенский парк</h3>
                            </div>

                        </div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="swiper-slide">
                        <img src="{{ asset('images/galery.jpg') }}" alt="Крещенский парк" />
                        <div class="slide-overlay">
                            <div class="slide-header">
                                <img src="{{ asset('images/Logo2.svg') }}" alt="Логотип" class="slide-icon">
                                <h3 class="slide-title">Крещенский парк</h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.photo-section')

    @include('partials.contacts-partials')

    <!-- Яндекс Карта -->
    <div class="container mt-5 mb-5">
        <div class="map-section">
            <div class="title text-center mb-4">КАК НАС НАЙТИ</div>
            <div class="map-container" style="position:relative;overflow:hidden;">
                <iframe
                    src="https://yandex.ru/map-widget/v1/?um=constructor%3A17b72ba8b2573a27deae651cf3dda2b9b30e2e9495077444e9acd7e960fd889c&amp;source=constructor"
                    width="100%" height="500" frameborder="0" style="border:0; border-radius: 12px;"
                    sandbox="allow-scripts allow-same-origin allow-popups allow-forms" loading="lazy"></iframe>
            </div>
        </div>
    </div>

    @include('partials.footer')

    @include('partials.scripts')
</body>

</html>
