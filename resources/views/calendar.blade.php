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

            <div class="today-events mb-4">
                <h2 class="h4 mb-3 montserrat-font">Мероприятия на {{ $today->format('d.m.Y') }}</h2>

                @if (isset($dayEvents) && $dayEvents->isNotEmpty())
                    @foreach ($dayEvents as $event)
                        <article class="card mb-2">
                            <div class="card-body d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-muted small mb-1 montserrat-font">
                                        {{ $event->start->format('H:i') }}
                                        @if ($event->end)
                                            — {{ $event->end->format('H:i') }}
                                        @endif
                                    </div>
                                    <h3 class="h5 mb-1 montserrat-font">{{ $event->title }}</h3>
                                    @if ($event->description)
                                        <div class="text-muted montserrat-font">{!! nl2br(e($event->description)) !!}</div>
                                    @endif
                                </div>

                                @if (!empty($event->color))
                                    <div class="ms-3"
                                        style="width:12px;height:48px;background:{{ $event->color }};border-radius:6px;">
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                @else
                    <p class="text-muted">Сегодня мероприятий нет.</p>
                @endif
            </div>

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
