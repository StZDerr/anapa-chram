<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.seo')
    @include('partials.head')

    <!-- Стили страницы Zapiski -->
    @vite(['resources/css/zapiski.css', 'resources/js/zapiski.js', 'resources/css/donation-modal.css', 'resources/css/prayer-modal.css', 'resources/js/prayer-modal.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <div class="notes-page">
            <div class="container py-5">
                <h1 class="title text-center mb-5">ЗАПИСКИ</h1>
                <div class="zapiski-grid">
                    <!-- Карточка 1 -->
                    <div class="zapiski-card">
                        <div class="zapiski-card-image">
                            <img src="{{ asset('images/donation/note-photo.webp') }}" alt="Заказная записка">
                        </div>
                        <div class="zapiski-card-body">
                            <h3 class="zapiski-card-title">Заказная записка<br>(10 имен)</h3>
                            <p class="zapiski-card-price">100 руб.</p>
                            <button class="zapiski-btn" data-bs-toggle="modal" data-bs-target="#prayerModal"
                                data-type="Заказная записка (10 имен)" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>

                    <!-- Карточка 2 -->
                    <div class="zapiski-card">
                        <div class="zapiski-card-image">
                            <img src="{{ asset('images/donation/note-photo.webp') }}" alt="Заказная записка">
                        </div>
                        <div class="zapiski-card-body">
                            <h3 class="zapiski-card-title">Заказная записка<br>(10 имен)</h3>
                            <p class="zapiski-card-price">100 руб.</p>
                            <button class="zapiski-btn" data-bs-toggle="modal" data-bs-target="#prayerModal"
                                data-type="Заказная записка (10 имен)" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>

                    <!-- Карточка 3 -->
                    <div class="zapiski-card">
                        <div class="zapiski-card-image">
                            <img src="{{ asset('images/donation/note-photo.webp') }}" alt="Заказная записка">
                        </div>
                        <div class="zapiski-card-body">
                            <h3 class="zapiski-card-title">Заказная записка<br>(10 имен)</h3>
                            <p class="zapiski-card-price">100 руб.</p>
                            <button class="zapiski-btn" data-bs-toggle="modal" data-bs-target="#zapiskiModal"
                                data-type="Заказная записка (10 имен)" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>

                    <!-- Карточка 4 -->
                    <div class="zapiski-card">
                        <div class="zapiski-card-image">
                            <img src="{{ asset('images/donation/note-photo.webp') }}" alt="Заказная записка">
                        </div>
                        <div class="zapiski-card-body">
                            <h3 class="zapiski-card-title">Заказная записка<br>(10 имен)</h3>
                            <p class="zapiski-card-price">100 руб.</p>
                            <button class="zapiski-btn" data-bs-toggle="modal" data-bs-target="#zapiskiModal"
                                data-type="Заказная записка (10 имен)" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>

                    <!-- Карточка 5 -->
                    <div class="zapiski-card">
                        <div class="zapiski-card-image">
                            <img src="{{ asset('images/donation/note-photo.webp') }}" alt="Заказная записка">
                        </div>
                        <div class="zapiski-card-body">
                            <h3 class="zapiski-card-title">Заказная записка<br>(10 имен)</h3>
                            <p class="zapiski-card-price">100 руб.</p>
                            <button class="zapiski-btn" data-bs-toggle="modal" data-bs-target="#zapiskiModal"
                                data-type="Заказная записка (10 имен)" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>

                    <!-- Карточка 6 -->
                    <div class="zapiski-card">
                        <div class="zapiski-card-image">
                            <img src="{{ asset('images/donation/note-photo.webp') }}" alt="Заказная записка">
                        </div>
                        <div class="zapiski-card-body">
                            <h3 class="zapiski-card-title">Заказная записка<br>(10 имен)</h3>
                            <p class="zapiski-card-price">100 руб.</p>
                            <button class="zapiski-btn" data-bs-toggle="modal" data-bs-target="#zapiskiModal"
                                data-type="Заказная записка (10 имен)" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>

                    <!-- Карточка 7 -->
                    <div class="zapiski-card">
                        <div class="zapiski-card-image">
                            <img src="{{ asset('images/donation/note-photo.webp') }}" alt="Заказная записка">
                        </div>
                        <div class="zapiski-card-body">
                            <h3 class="zapiski-card-title">Заказная записка<br>(10 имен)</h3>
                            <p class="zapiski-card-price">100 руб.</p>
                            <button class="zapiski-btn" data-bs-toggle="modal" data-bs-target="#zapiskiModal"
                                data-type="Заказная записка (10 имен)" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>

                    <!-- Карточка 8 -->
                    <div class="zapiski-card">
                        <div class="zapiski-card-image">
                            <img src="{{ asset('images/donation/note-photo.webp') }}" alt="Заказная записка">
                        </div>
                        <div class="zapiski-card-body">
                            <h3 class="zapiski-card-title">Заказная записка<br>(10 имен)</h3>
                            <p class="zapiski-card-price">100 руб.</p>
                            <button class="zapiski-btn" data-bs-toggle="modal" data-bs-target="#zapiskiModal"
                                data-type="Заказная записка (10 имен)" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>

                    <!-- Карточка 9 -->
                    <div class="zapiski-card">
                        <div class="zapiski-card-image">
                            <img src="{{ asset('images/donation/note-photo.webp') }}" alt="Заказная записка">
                        </div>
                        <div class="zapiski-card-body">
                            <h3 class="zapiski-card-title">Заказная записка<br>(10 имен)</h3>
                            <p class="zapiski-card-price">100 руб.</p>
                            <button class="zapiski-btn" data-bs-toggle="modal" data-bs-target="#zapiskiModal"
                                data-type="Заказная записка (10 имен)" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>

                    <!-- Карточка 10 -->
                    <div class="zapiski-card">
                        <div class="zapiski-card-image">
                            <img src="{{ asset('images/donation/note-photo.webp') }}" alt="Заказная записка">
                        </div>
                        <div class="zapiski-card-body">
                            <h3 class="zapiski-card-title">Заказная записка<br>(10 имен)</h3>
                            <p class="zapiski-card-price">100 руб.</p>
                            <button class="zapiski-btn" data-bs-toggle="modal" data-bs-target="#zapiskiModal"
                                data-type="Заказная записка (10 имен)" data-price="100">
                                Пожертвовать
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="donation">
            <div class="container py-5">
                <div class="text-center title m-4">ПОЖЕРТВОВАНИЕ</div>
                <!-- Hero секция с фотографией храма -->
                <section class="hero-section">
                    <div class="hero-image">
                        <img src="{{ asset('images/donation/donatio-back.webp') }}"
                            alt="Храм святого князя Владимира">
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

    <!-- Модальное окно для записок -->
    <div class="modal fade" id="zapiskiModal" tabindex="-1" aria-labelledby="zapiskiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="zapiskiModalLabel">Оформление записки</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form id="zapiskiForm" novalidate>
                        <div class="mb-3">
                            <label for="zapiskiType" class="form-label">Тип записки</label>
                            <input type="text" class="form-control" id="zapiskiType" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="zapiskiAmount" class="form-label">Сумма пожертвования (руб.)</label>
                            <input type="number" class="form-control" id="zapiskiAmount" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="zapiskiName" class="form-label">Ваше имя</label>
                            <input type="text" class="form-control" id="zapiskiName" required>
                            <div class="invalid-feedback">
                                Пожалуйста, введите ваше имя.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="zapiskiEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="zapiskiEmail" required>
                            <div class="invalid-feedback">
                                Пожалуйста, введите корректный email.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="zapiskiPhone" class="form-label">Телефон</label>
                            <input type="tel" class="form-control" id="zapiskiPhone" required>
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
    @include('partials.prayer-modal')
</body>

</html>
