<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Храм святого князя Владимира в Анапе</title>
    @include('partials.head')

    <!-- Стили и скрипты главной страницы (loader + welcome) -->
    @vite(['resources/js/photo-section.js', 'resources/css/calendar-swiper.css', 'resources/js/calendar-swiper.js', 'resources/css/activity-swiper.css', 'resources/js/activity-swiper.js', 'resources/css/loader.css', 'resources/css/welcome.css', 'resources/js/loader.js', 'resources/js/welcome.js', 'resources/css/photo-section.css', 'resources/css/news-swiper.css', 'resources/js/news-swiper.js', 'resources/css/park-swiper.css'])
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

    @include('partials.park-partials')

    @include('partials.photo-section')

    @include('partials.contacts-partials')



    @include('partials.footer')

    @include('partials.scripts')
</body>

</html>
