<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.seo')
    @include('partials.head')

    <!-- PhotoSwipe v5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe.css" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Стили страницы Temple -->
    @vite(['resources/css/app.css', 'resources/css/activity-swiper.css', 'resources/js/activity-swiper.js', 'resources/js/photo-section.js', 'resources/css/temple.css', 'resources/css/donation-modal.css', 'resources/js/temple.js', 'resources/css/photo-section.css', 'resources/css/clergy.css', 'resources/css/donation.css', 'resources/css/timetable.css'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <div class="container py-5">
            <h1 class="text-center temple-title mb-5">
                {{ $activity->title }}
            </h1>

            <!-- Основной контент -->
            <div class="temple-content">
                <div class="row">
                    <div class="col-sm-12 col-lg-6 d-flex align-items-center">
                        <div class="swiper-container-wrapper w-100 sticky-swiper">
                            <!-- Большое изображение -->
                            <div class="swiper gallery-top gallery-swiper gallery-instance">
                                <div class="swiper-wrapper">
                                    @if ($activity->images && $activity->images->count() > 0)
                                        @foreach ($activity->images as $image)
                                            @php
                                                $storagePath = storage_path('app/public/' . $image->path);
                                                $imgSize = @getimagesize($storagePath);
                                                $imgW = $imgSize[0] ?? 1200;
                                                $imgH = $imgSize[1] ?? 800;
                                            @endphp
                                            @if (Storage::disk('public')->exists($image->path))
                                                <div class="swiper-slide">
                                                    <a href="{{ Storage::url($image->path) }}"
                                                        data-pswp-width="{{ $imgW }}"
                                                        data-pswp-height="{{ $imgH }}" data-cropped="true"
                                                        target="_blank" rel="noopener">
                                                        <img src="{{ Storage::url($image->path) }}"
                                                            alt="Фото {{ $loop->iteration }}">
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        @if ($activity->img_preview && Storage::disk('public')->exists($activity->img_preview))
                                            <div class="swiper-slide">
                                                <a href="{{ Storage::url($activity->img_preview) }}">
                                                    <img src="{{ Storage::url($activity->img_preview) }}"
                                                        alt="{{ $activity->title }}">
                                                </a>
                                            </div>
                                        @else
                                            <div class="swiper-slide">
                                                <img src="{{ asset('images/ChramSvitogo.jpg') }}"
                                                    alt="{{ $activity->title }}">
                                            </div>
                                        @endif
                                    @endif
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
                                    @if ($activity->images && $activity->images->count() > 0)
                                        @foreach ($activity->images as $image)
                                            @if (Storage::disk('public')->exists($image->path))
                                                <div class="swiper-slide">
                                                    <img src="{{ Storage::url($image->path) }}"
                                                        alt="Фото {{ $loop->iteration }}">
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        @if ($activity->img_preview && Storage::disk('public')->exists($activity->img_preview))
                                            <div class="swiper-slide">
                                                <img src="{{ Storage::url($activity->img_preview) }}"
                                                    alt="{{ $activity->title }}">
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        {{-- <div class="title">О храме</div> --}}
                        <div class="details fs-5">
                            <div class="activity-meta mb-3 text-muted">
                                {{ $activity->published_at ? $activity->published_at->format('d.m.Y') : $activity->created_at->format('d.m.Y') }}
                            </div>
                            {!! $activity->content !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @include('partials.timetable-partials')

        @include('partials.activity-partials')
    </main>

    @include('partials.donation-modal')

    @include('partials.footer')

    @include('partials.scripts')

</body>

</html>
