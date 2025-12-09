<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Деятельность храма - Храм святого князя Владимира в Анапе</title>
    @include('partials.head')

    <!-- Стили страницы Activity -->
    @vite(['resources/css/activity.css'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <div class="container py-5">
            <h1 class="title text-center mb-5">ДЕЯТЕЛЬНОСТЬ ХРАМА</h1>
            <div class="activity-grid">
                @forelse ($activities as $activity)
                    <!-- Карточка 1 -->
                    <div class="activity-card">
                        <a href="{{ route('activity.read', $activity->slug) }}">
                            <div class="activity-card-image">
                                <img src="{{ $activity->img_preview ? asset('storage/' . $activity->img_preview) : asset('images/newsOne.jpg') }}"
                                    alt="{{ $activity->title }}" class="activity-slide-img">
                            </div>
                            <div class="activity-card-overlay">
                                <h3 class="activity-card-title">{{ $activity->title }}</h3>
                                <p class="activity-card-description">
                                    {{ Str::limit(strip_tags($activity->content), 132) }}
                                </p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="no-activities-message">Деятельность храма пока не добавлена.</p>
                @endforelse
            </div>
        </div>
    </main>

    @include('partials.footer')

    @include('partials.scripts')
</body>

</html>
