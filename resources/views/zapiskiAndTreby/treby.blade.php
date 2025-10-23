<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Требы - Храм святого князя Владимира в Анапе</title>
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
                <h1 class="title text-center mb-5">ТРЕБЫ</h1>
                <div class="treby-grid">
                    <!-- Карточка 1 - Венчание -->
                    <div class="treby-card">
                        <div class="treby-card-image">
                            <img src="{{ asset('images/treby/Wedding.webp') }}" alt="Венчание">
                        </div>
                        <div class="treby-card-body">
                            <h3 class="treby-card-title">Венчание</h3>
                            <p class="treby-card-price">100 руб.</p>
                            <button class="treby-btn" data-bs-toggle="modal" data-bs-target="#trebyModal"
                                data-type="Венчание" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>

                    <!-- Карточка 2 - Крещение -->
                    <div class="treby-card">
                        <div class="treby-card-image">
                            <img src="{{ asset('images/treby/Baptism.webp') }}" alt="Крещение">
                        </div>
                        <div class="treby-card-body">
                            <h3 class="treby-card-title">Крещение</h3>
                            <p class="treby-card-price">100 руб.</p>
                            <button class="treby-btn" data-bs-toggle="modal" data-bs-target="#trebyModal"
                                data-type="Крещение" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>

                    <!-- Карточка 3 - Освещение -->
                    <div class="treby-card">
                        <div class="treby-card-image">
                            <img src="{{ asset('images/treby/Lighting.webp') }}" alt="Освещение">
                        </div>
                        <div class="treby-card-body">
                            <h3 class="treby-card-title">Освещение</h3>
                            <p class="treby-card-price">100 руб.</p>
                            <button class="treby-btn" data-bs-toggle="modal" data-bs-target="#trebyModal"
                                data-type="Освещение" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>

                    <!-- Карточка 4 - Отпевание -->
                    <div class="treby-card">
                        <div class="treby-card-image">
                            <img src="{{ asset('images/treby/Funeral.webp') }}" alt="Отпевание">
                        </div>
                        <div class="treby-card-body">
                            <h3 class="treby-card-title">Отпевание</h3>
                            <p class="treby-card-price">100 руб.</p>
                            <button class="treby-btn" data-bs-toggle="modal" data-bs-target="#trebyModal"
                                data-type="Отпевание" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>
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

    <!-- Модальное окно для треб -->
    <div class="modal fade" id="trebyModal" tabindex="-1" aria-labelledby="trebyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trebyModalLabel">Оформление требы</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form id="trebyForm" novalidate>
                        <div class="mb-3">
                            <label for="trebyType" class="form-label">Тип требы</label>
                            <input type="text" class="form-control" id="trebyType" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="trebyAmount" class="form-label">Сумма пожертвования (руб.)</label>
                            <input type="number" class="form-control" id="trebyAmount" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="trebyName" class="form-label">Ваше имя</label>
                            <input type="text" class="form-control" id="trebyName" required>
                            <div class="invalid-feedback">
                                Пожалуйста, введите ваше имя.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="trebyEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="trebyEmail" required>
                            <div class="invalid-feedback">
                                Пожалуйста, введите корректный email.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="trebyPhone" class="form-label">Телефон</label>
                            <input type="tel" class="form-control" id="trebyPhone" required>
                            <div class="invalid-feedback">
                                Пожалуйста, введите номер телефона.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('partials.donation-modal')
</body>

</html>
