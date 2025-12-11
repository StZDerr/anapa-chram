<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>О храме - Храм святого князя Владимира в Анапе</title>
    @include('partials.head')

    <!-- Стили страницы About -->
    @vite(['resources/css/about.css', 'resources/css/donation-modal.css', 'resources/css/quick.css'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        @include('partials.quick-partials')

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

        <div class="notes">
            <div class="container">
                <div class="title">ЗАПИСКИ И ТРЕБЫ</div>
                <div class="zapiski-grid">
                    <!-- Карточка 1 -->
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

                    <!-- Карточка 2 -->
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
                </div>

                <!-- Ссылка "Перейти ко всем запискам" -->
                <div class="text-center mt-4">
                    <a href="{{ route('zapiski') }}" class="zapiski-link">Перейти ко всем запискам</a>
                </div>
            </div>
        </div>
    </main>

    @include('partials.donation-modal')

    <!-- Модальное окно для записок -->
    <div class="modal fade" id="zapiskiModal" tabindex="-1" aria-labelledby="zapiskiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content donation-modal">
                <!-- Кнопка закрытия -->
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>

                <div class="modal-body p-5">
                    <!-- Заголовок -->
                    <h2 class="donation-modal-title text-center mb-4">Пожертвование</h2>

                    <!-- Описание -->
                    <p class="donation-modal-description text-center mb-4">
                        Наш храм существует за счет средств попечителей и пожертвований прихожан.<br>
                        На пожертвования мы оформляем храм, оплачиваем работу сотрудников<br>
                        и занимаемся благотворительностью
                    </p>

                    <!-- Форма -->
                    <form id="zapiskiForm">
                        <!-- Скрытые поля для типа и цены -->
                        <input type="hidden" id="zapiskiType" name="type">
                        <input type="hidden" id="zapiskiPrice" name="price">

                        <!-- Поле для ввода суммы (предзаполненное) -->
                        <div class="mb-4">
                            <label for="zapiskiAmount" class="donation-label">Введите сумму пожертвования:</label>
                            <input type="number" class="form-control donation-input" id="zapiskiAmount"
                                placeholder="Введите сумму" min="1" required readonly>
                        </div>

                        <!-- Чекбокс согласия -->
                        <div class="form-check mb-4">
                            <input class="form-check-input donation-checkbox" type="checkbox" id="zapiskiConsent"
                                required>
                            <label class="form-check-label donation-checkbox-label" for="zapiskiConsent">
                                Я согласен с <a href="#" class="donation-link">обработкой персональных
                                    данных</a>
                            </label>
                        </div>

                        <!-- Кнопка отправки -->
                        <div class="text-center">
                            <button type="submit" class="btn-donation-submit">Пожертвовать</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    @include('partials.scripts')

    <script>
        // Обработка отправки формы пожертвования
        document.getElementById('donationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const amount = document.getElementById('donationAmount').value;
            const consent = document.getElementById('privacyConsent').checked;

            if (amount && consent) {
                // Здесь будет логика обработки платежа
                alert('Спасибо за пожертвование в размере ' + amount + ' руб.!');
                // Закрыть модальное окно
                bootstrap.Modal.getInstance(document.getElementById('donationModal')).hide();
            }
        });

        // Обработка открытия модального окна записок
        const zapiskiModal = document.getElementById('zapiskiModal');
        zapiskiModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const type = button.getAttribute('data-type');
            const price = button.getAttribute('data-price');

            document.getElementById('zapiskiType').value = type;
            document.getElementById('zapiskiPrice').value = price;
            document.getElementById('zapiskiAmount').value = price;
        });

        // Обработка отправки формы записок
        document.getElementById('zapiskiForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const type = document.getElementById('zapiskiType').value;
            const amount = document.getElementById('zapiskiAmount').value;
            const consent = document.getElementById('zapiskiConsent').checked;

            if (amount && consent) {
                // Здесь будет логика обработки платежа
                alert('Спасибо за заказ: ' + type + ' на сумму ' + amount + ' руб.!');
                // Закрыть модальное окно
                bootstrap.Modal.getInstance(document.getElementById('zapiskiModal')).hide();
            }
        });
    </script>
</body>

</html>
