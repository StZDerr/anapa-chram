<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.seo')
    @include('partials.head')

    <!-- Стили страницы News -->
    @vite(['resources/css/news.css'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <div class="news-page">
            <div class="container py-5">
                <h1 class="title text-center mb-5">НОВОСТИ И СОБЫТИЯ</h1>
                <div class="news-grid">
                    <!-- Карточка 1 -->
                    @forelse ($news as $newsItem)
                        <div class="news-card">
                            <div class="news-card-image">
                                <img src="{{ $newsItem->img_preview ? asset('storage/' . $newsItem->img_preview) : asset('images/newsOne.jpg') }}"
                                    alt="{{ $newsItem->title }}" class="slide-img">
                            </div>
                            <div class="news-card-body">
                                <h3 class="news-card-title">{{ $newsItem->title }}</h3>
                                <div class="slide-desc">
                                    {{ Str::limit(strip_tags($newsItem->content), 70) }}
                                </div>
                                <a href="{{ route('news.read', $newsItem->slug) }}" class="news-btn">Читать</a>
                            </div>
                        </div>
                    @empty
                        <div class="null">Новостей пока нет</div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    @include('partials.scripts')
</body>

</html>
