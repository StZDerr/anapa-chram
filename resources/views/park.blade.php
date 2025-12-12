<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.seo')
    @include('partials.head')

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Стили страницы Park -->
    @vite(['resources/css/park.css', 'resources/js/park.js', 'resources/css/park-swiper.css'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        @include('partials.park-partials')
        <div class="container">
            <div class="attractions">
                <div class="text-center title mb-5">ДОСТОПРИМЕЧАТЕЛЬНОСТИ</div>
                <div class="swiper attractionsSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($attractions as $attraction)
                            <div class="swiper-slide">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="swiper-slide-title text-center">
                                            {{ $attraction->title }}
                                        </div>
                                        <div class="swiper-slide-description">
                                            {{ $attraction->description }}
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 order">
                                        @if ($attraction->image)
                                            <img src="/storage/{{ $attraction->image }}" alt="{{ $attraction->title }}">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
        <!-- Правила посещения -->
        <div class="rules">
            <div class="container">
                <div class="row g-4">
                    <!-- Правила посещения -->
                    <div class="col-12 col-lg-6">
                        <div class="rules-card rules-card-allowed">
                            <div class="rules-header">
                                <img src="{{ asset('images/Logo2-gold.webp') }}" alt="Логотип" class="rules-icon">
                                <div class="rules-header-text">
                                    <h3 class="rules-title">{{ $parkRule->allowed_title }}</h3>
                                    <p class="rules-subtitle">{{ $parkRule->allowed_subtitle }}</p>
                                </div>
                            </div>
                            <div class="rules-content">
                                @if (!empty($parkRule) && $parkRule->allowed_items->isNotEmpty())
                                    <ul class="rules-list">
                                        @foreach ($parkRule->allowed_items as $item)
                                            <li>
                                                <span class="marker">
                                                    @if (!empty($item['svg']))
                                                        <img src="{{ asset('storage/' . $item['svg']) }}"
                                                            alt="">
                                                    @else
                                                        <span class="dot"></span>
                                                    @endif
                                                </span>
                                                <span class="text">{!! nl2br(e($item['title'])) !!}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <ul class="rules-list">
                                        <li>
                                            <span class="marker"><span class="dot"></span></span>
                                            <span class="text">Соблюдайте общепринятые нормы поведения, не наносите
                                                повреждений имуществу парка.</span>
                                        </li>
                                        <li>
                                            <span class="marker"><span class="dot"></span></span>
                                            <span class="text">Соблюдайте правила пользования детскими и спортивными
                                                площадками.</span>
                                        </li>
                                        <li>
                                            <span class="marker"><span class="dot"></span></span>
                                            <span class="text">Соблюдайте правила пожарной безопасности.</span>
                                        </li>
                                        <li>
                                            <span class="marker"><span class="dot"></span></span>
                                            <span class="text">В случае обнаружения вещей без присмотра... сообщите
                                                сотрудникам парка.</span>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Запрещается -->
                    <div class="col-12 col-lg-6">
                        <div class="rules-card rules-card-prohibited">
                            <div class="rules-header">
                                <div class="rules-header-text">
                                    <h3 class="rules-title">{{ $parkRule->prohibited_title }}</h3>
                                    <p class="rules-subtitle">{{ $parkRule->prohibited_subtitle }}</p>
                                </div>
                            </div>
                            <div class="rules-content">
                                <ul class="rules-list-prohibited">
                                    @foreach ($parkRule->prohibited_items as $item)
                                        <li>
                                            <div class="prohibited-icon">
                                                @if (!empty($item['svg']))
                                                    <img src="{{ asset('storage/' . $item['svg']) }}" alt="">
                                                @else
                                                    <span class="dot"></span>
                                                @endif
                                            </div>
                                            <span>{!! nl2br(e($item['title'])) !!}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Строительство храма -->
        <div class="construction">
            <div class="container">
                <h2 class="text-center title mb-5">СТРОИТЕЛЬСТВО ХРАМА</h2>
                <div class="row">
                    <div class="col-12 col-lg-6 d-flex">
                        @if ($construction && $construction->images->isNotEmpty())
                            <div class="swiper-container-wrapper"
                                style="width:100%; align-self:flex-start; position:sticky; top:100px; z-index:2;">
                                <!-- Большое изображение -->
                                <div class="swiper construction-gallery-top">
                                    <div class="swiper-wrapper">
                                        @foreach ($construction->images as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ $image->image_url }}"
                                                    alt="{{ $construction->title }} - изображение {{ $image->order }}">
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Стрелки -->
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>

                                <!-- Превью (миниатюры) -->
                                <div class="swiper construction-gallery-thumbs mt-3">
                                    <div class="swiper-wrapper">
                                        @foreach ($construction->images as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ $image->image_url }}"
                                                    alt="{{ $construction->title }} - превью {{ $image->order }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info w-100">
                                <i class="fas fa-info-circle"></i> Изображения строительства храма пока не загружены.
                            </div>
                        @endif
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="construction-info">
                            <h3 class="construction-subtitle">{{ $construction->title }}</h3>
                            <p class="construction-text">
                                {{ $construction->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    @include('partials.scripts')

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>
