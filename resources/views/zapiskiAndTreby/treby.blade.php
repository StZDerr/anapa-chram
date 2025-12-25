<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.seo')
    @include('partials.head')

    <!-- Стили страницы Treby -->
    @vite(['resources/css/treby.css', 'resources/css/donation-modal.css', 'resources/js/treby.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <!-- Секция карточек треб -->
        <div class="treby-cards-section">
            <div class="container py-5">
                <h1 class="title text-center mb-5">Пожертвование за церковные Таинства</h1>
                <div class="treby-grid">
                    <!-- Карточка 1 - Венчание -->
                    @forelse ($blocks as $block)
                        <div class="treby-card">
                            <div class="treby-card-image">
                                <img src="{{ asset('storage/' . $block->preview_img) }}" alt="{{ $block->title }}">
                            </div>
                            <div class="treby-card-body">
                                <h3 class="treby-card-title">{{ $block->title }}</h3>
                                <p class="treby-card-price">
                                    @if ($block->price)
                                        {{ number_format($block->price, 2, '.', '') }} руб.
                                    @elseif($block->title_desc)
                                        {{ \Illuminate\Support\Str::limit(strip_tags($block->title_desc), 50) }}
                                    @endif
                                </p>
                                <a href="{{ route('treby.show', $block->slug ?? $block->id) }}" class="treby-btn">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                    @empty
                        <p>Нет доступных блоков контента.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Секция пожертвования -->
        <div class="donation">
            <div class="container py-5">
                <div class="text-center title m-4">ПОЖЕРТВОВАНИЕ</div>
                <!-- Hero секция с фотографией храма -->
                <section class="hero-section">
                    <div class="hero-image">
                        <img src="{{ asset('images/donation/donatio-back.webp') }}" alt="Храм святого князя Владимира">
                    </div>
                    <div class="hero-overlay">
                        <div class="hero-content">
                            <div class="hero-logo">
                                <img src="{{ asset('images/logo.svg') }}" alt="Логотип храма">
                            </div>
                            <div class="hero-quote">
                                <p>"ЕСЛИ НА ВАШУ ДОЛЮ ВЫПАЛА ЧЕСТЬ СТРОИТЬ ДОМ БОЖИЙ, ПРИМИТЕ ЭТО КАК ВЕЛИКИЙ ДАР
                                    ТВОРЦА,
                                    ИБО
                                    ДЕСНИЦА ГОСПОДНЯ КАСАЕТСЯ ТОГО, КТО СТРОИТ ХРАМЫ, И МНОГИЕ ГРЕХИ ПРОСТИТ ТОМУ
                                    ГОСПОДЬ."
                                </p>
                                <p class="hero-author">СВЯТОЙ ПРАВЕДНЫЙ ИОАНН КРОНШТАДСКИЙ</p>
                            </div>
                            <button class="hero-btn" data-bs-toggle="modal"
                                data-bs-target="#donationModal">Пожертвовать</button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    @include('partials.footer')

    @include('partials.scripts')

    @include('partials.donation-modal')
</body>

</html>
