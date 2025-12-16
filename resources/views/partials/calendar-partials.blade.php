<div class="background-color-light-beige pb-3 pt-3">
    <div class="container">
        <div class="calendar">
            <div class="text-center title">ПРАВОСЛАВНЫЙ КАЛЕНДАРЬ</div>

            <!-- Swiper-карусель с 7 днями недели -->
            <div class="calendar-swiper-wrapper my-4">
                <button class="btn-calendar-nav calendar-prev" aria-label="Предыдущий">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>

                <div class="swiper calendar-swiper">
                    <div class="swiper-wrapper" id="calendar-slides">
                        <!-- Слайды генерируются динамически -->
                    </div>
                </div>

                <button class="btn-calendar-nav calendar-next" aria-label="Следующий">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для полной информации -->
<div class="calendar-modal" id="calendarModal">
    <div class="calendar-modal-overlay"></div>
    <div class="calendar-modal-content">
        <button class="calendar-modal-close" aria-label="Закрыть">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="calendar-modal-header">
            <div class="calendar-modal-day" id="modalDay"></div>
            <div class="calendar-modal-date" id="modalDate"></div>
        </div>
        <div class="calendar-modal-body" id="modalBody">
            <div class="calendar-modal-loading">Загрузка...</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dayNames = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
        const monthNames = ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа',
            'Сентября', 'Октября', 'Ноября', 'Декабря'
        ];
        const monthNamesShort = ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя',
            'Дек'
        ];

        // Кэш загруженных данных
        const calendarCache = {};

        // Получить даты текущей недели (3 дня назад, сегодня, 3 дня вперед)
        function getWeekDates() {
            const today = new Date();
            const dates = [];

            for (let i = -3; i <= 3; i++) {
                const date = new Date(today);
                date.setDate(today.getDate() + i);
                dates.push(date);
            }

            return dates;
        }

        // Форматировать дату для отображения
        function formatDateDisplay(date) {
            const day = date.getDate();
            const month = monthNames[date.getMonth()];
            return `${day} ${month}`;
        }

        // Загрузить данные календаря через AJAX
        function loadCalendarData(date, callback) {
            const cacheKey = date.toISOString().split('T')[0];

            if (calendarCache[cacheKey]) {
                callback(calendarCache[cacheKey]);
                return;
            }

            const day = date.getDate().toString().padStart(2, '0');
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            const params =
                `/script-kalendar/pppr.php?month=${month}&today=${day}&year=${year}&dt=0&header=1&lives=1&trp=0&scripture=0&sid=${Math.random()}`;

            fetch(params)
                .then(response => response.text())
                .then(html => {
                    calendarCache[cacheKey] = html;
                    callback(html);
                })
                .catch(error => {
                    console.error('Ошибка загрузки календаря:', error);
                    callback('<p>Ошибка загрузки данных</p>');
                });
        }

        // Извлечь краткий текст из HTML (первые 100 символов)
        function extractShortText(html) {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;

            // Удалить скрипты и стили
            tempDiv.querySelectorAll('script, style').forEach(el => el.remove());

            // Получить текст
            let text = tempDiv.textContent || tempDiv.innerText || '';
            text = text.replace(/\s+/g, ' ').trim();

            // Обрезать до 100 символов
            if (text.length > 100) {
                text = text.substring(0, 100) + '...';
            }

            return text || 'Загрузка...';
        }

        // Создать слайды (загрузка последовательная для обхода rate limit)
        async function createSlides() {
            const dates = getWeekDates();
            const slidesContainer = document.getElementById('calendar-slides');
            slidesContainer.innerHTML = '';

            // Сначала создаём все слайды с плейсхолдерами
            dates.forEach((date, index) => {
                const slide = document.createElement('div');
                slide.className = 'swiper-slide';

                const isToday = date.toDateString() === new Date().toDateString();

                slide.innerHTML = `
                <div class="calendar-card ${isToday ? 'calendar-card--today' : ''}" data-date="${date.toISOString()}">
                    <div class="calendar-day">${dayNames[date.getDay()]}</div>
                    <div class="calendar-date">${formatDateDisplay(date)}</div>
                    <div class="calendar-desc" data-date="${date.toISOString()}">Загрузка...</div>
                </div>
            `;

                slidesContainer.appendChild(slide);
            });

            // Затем загружаем данные последовательно с задержкой (обход rate limit)
            for (let i = 0; i < dates.length; i++) {
                const date = dates[i];
                const slide = slidesContainer.children[i];

                // Загружаем данные
                await new Promise(resolve => {
                    loadCalendarData(date, function(html) {
                        const descEl = slide.querySelector('.calendar-desc');
                        if (descEl) {
                            descEl.textContent = extractShortText(html);
                        }
                        resolve();
                    });
                });

                // Задержка 300ms между запросами (чтобы не превысить rate limit 1r/s с burst=5)
                if (i < dates.length - 1) {
                    await new Promise(r => setTimeout(r, 300));
                }
            }
        }

        // Инициализировать Swiper
        function initSwiper() {
            return new Swiper('.calendar-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                centeredSlides: true,
                initialSlide: 3, // Текущий день в центре (индекс 3 из 7)
                navigation: {
                    nextEl: '.calendar-next',
                    prevEl: '.calendar-prev',
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2,
                    },
                    992: {
                        slidesPerView: 3,
                    },
                },
            });
        }

        // Модальное окно
        const modal = document.getElementById('calendarModal');
        const modalOverlay = modal.querySelector('.calendar-modal-overlay');
        const modalClose = modal.querySelector('.calendar-modal-close');
        const modalDay = document.getElementById('modalDay');
        const modalDate = document.getElementById('modalDate');
        const modalBody = document.getElementById('modalBody');

        function openModal(date) {
            const dateObj = new Date(date);

            modalDay.textContent = dayNames[dateObj.getDay()];
            modalDate.textContent = formatDateDisplay(dateObj);
            modalBody.innerHTML = '<div class="calendar-modal-loading">Загрузка...</div>';

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';

            loadCalendarData(dateObj, function(html) {
                modalBody.innerHTML = html;
            });
        }

        function closeModal() {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        modalOverlay.addEventListener('click', closeModal);
        modalClose.addEventListener('click', closeModal);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeModal();
            }
        });

        // Клик по карточке
        document.getElementById('calendar-slides').addEventListener('click', function(e) {
            const card = e.target.closest('.calendar-card');
            if (card) {
                openModal(card.dataset.date);
            }
        });

        // Инициализация
        createSlides();
        initSwiper();
    });
</script>
