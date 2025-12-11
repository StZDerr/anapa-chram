<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.seo')
    @include('partials.head')

    <!-- Стили и скрипты главной страницы (loader + welcome) -->
    @vite(['resources/js/photo-section.js', 'resources/css/calendar-swiper.css', 'resources/js/calendar-swiper.js', 'resources/css/activity-swiper.css', 'resources/js/activity-swiper.js', 'resources/css/loader.css', 'resources/css/welcome.css', 'resources/js/loader.js', 'resources/js/welcome.js', 'resources/css/photo-section.css', 'resources/css/news-swiper.css', 'resources/js/news-swiper.js', 'resources/css/park-swiper.css', 'resources/css/quick.css', 'resources/css/contact.css'])
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
    <div class="background-color-light-beige pb-3 pt-3">
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
