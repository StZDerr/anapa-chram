<div class="background-color-light-beige">
    <div class="container">
        <div class="calendar">
            <div class="text-center title">ПРАВОСЛАВНЫЙ КАЛЕНДАРЬ</div>

            <!-- Календарные блоки (Swiper) -->
            @php
                use Carbon\Carbon;
                use Illuminate\Support\Str;

                $today = $today ?? Carbon::today();
                $start = $today->copy()->subDays(3); // три дня до
                $dowNames = ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'];
            @endphp

            <div class="calendar-swiper-wrapper">
                <button class="btn-calendar-nav calendar-prev" aria-label="Prev">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <div class="swiper calendar-swiper">
                    <div class="swiper-wrapper">
                        @for ($i = 0; $i < 7; $i++)
                            @php
                                $dt = $start->copy()->addDays($i);
                                $events = ($orthodoxCalendars ?? collect())->filter(function ($it) use ($dt) {
                                    $itemDate = (string) $it->date;
                                    return Str::startsWith($itemDate, $dt->toDateString()) ||
                                        $itemDate === $dt->toDateString();
                                });
                            @endphp

                            <div class="swiper-slide">
                                <div
                                    class="calendar-card @if ($dt->isSameDay($today)) calendar-card--today @endif">
                                    <div class="calendar-day">{{ $dowNames[$dt->dayOfWeek] }}</div>
                                    <div class="calendar-date">{{ $dt->format('d.m.Y') }}</div>
                                    <div class="calendar-desc">
                                        @if ($events->isNotEmpty())
                                            @php
                                                $first = $events->first();
                                                $cnt = $events->count();
                                            @endphp
                                            <div class="calendar-event-title">{{ $first->title }}</div>
                                        @else
                                            <div class="text-muted small">Нет событий</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <button class="btn-calendar-nav calendar-next" aria-label="Next">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
