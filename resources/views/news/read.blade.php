<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.seo')
    @include('partials.head')

    <!-- Стили страницы News Read -->
    @vite(['resources/css/news-read.css', 'resources/js/news-read.js', 'resources/js/news-swiper.js', 'resources/css/news-swiper.css'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <!-- Hero секция с фоном -->
        <div class="news-hero">
            <div class="news-hero-overlay"></div>
            @if ($newsItem->img_preview && Storage::disk('public')->exists($newsItem->img_preview))
                <img src="{{ Storage::url($newsItem->img_preview) }}" alt="{{ $newsItem->title }}" class="news-hero-image">
            @else
                <img src="{{ asset('images/ChramSvitogo.jpg') }}" alt="{{ $newsItem->title }}" class="news-hero-image">
            @endif
            <div class="container">
                <div class="news-hero-content">
                    <div class="news-category">Новости храма</div>
                    <h1 class="news-hero-title">{{ $newsItem->title }}</h1>
                    <div class="news-meta">
                        <span class="news-date">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            {{ $newsItem->published_at ? $newsItem->published_at->format('d.m.Y') : $newsItem->created_at->format('d.m.Y') }}
                        </span>
                        <span class="news-author">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Пресс-служба храма
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Основной контент -->
        <div class="container">
            <div class="news-content">
                <div class="row justify-content-center">
                    <!-- Основной текст на всю ширину -->
                    <div class="col-lg-10 col-xl-9">
                        <article class="news-article">
                            <div class="news-content-display">
                                {!! $newsItem->content !!}
                            </div>
                        </article>


                        <!-- Фотогалерея -->
                        @if ($newsItem->images && $newsItem->images->count() > 0)
                            <div class="news-gallery-section">
                                <h2 class="section-title">Фотогалерея события</h2>
                                <div class="swiper newsGallerySwiper gallery-instance">
                                    <div class="swiper-wrapper">
                                        @foreach ($newsItem->images as $image)
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
                                                        <div class="gallery-overlay">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="40"
                                                                height="40" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2">
                                                                <circle cx="11" cy="11" r="8"></circle>
                                                                <line x1="21" y1="21" x2="16.65"
                                                                    y2="16.65"></line>
                                                                <line x1="11" y1="8" x2="11"
                                                                    y2="14"></line>
                                                                <line x1="8" y1="11" x2="14"
                                                                    y2="11"></line>
                                                            </svg>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next" aria-label="Следующее">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="9 6 15 12 9 18"></polyline>
                                        </svg>
                                    </div>
                                    <div class="swiper-button-prev" aria-label="Предыдущее">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <polyline points="15 6 9 12 15 18"></polyline>
                                        </svg>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Другие новости внизу страницы -->
        @include('partials.news-partials')
    </main>

    @include('partials.footer')
    @include('partials.scripts')
</body>

</html>
