import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import ruLocale from "@fullcalendar/core/locales/ru";

document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("calendar");
    const monthSelect = document.getElementById("month-select");
    const yearSelect = document.getElementById("year-select");

    // Заполнить селектор годов
    const currentYear = new Date().getFullYear();
    for (let year = currentYear - 2; year <= currentYear + 3; year++) {
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        if (year === currentYear) option.selected = true;
        yearSelect.appendChild(option);
    }

    // Установить текущий месяц
    monthSelect.value = new Date().getMonth();

    // Инициализация календаря
    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        locale: ruLocale,
        initialView: "dayGridMonth",
        headerToolbar: false, // Отключить стандартный тулбар
        dayHeaderFormat: { weekday: "short" },
        fixedWeekCount: false,
        showNonCurrentDates: true,
        height: "auto",
        dayMaxEvents: 0, // Не показывать события в ячейках
        displayEventTime: false, // Не показывать время события
        displayEventEnd: false,

        // Загрузка событий из API
        events: function (fetchInfo, successCallback, failureCallback) {
            const apiUrl = window.CALENDAR_EVENTS_URL || "/api/calendar/events";
            fetch(apiUrl)
                .then((response) => response.json())
                .then((data) => {
                    successCallback(data);
                    // После загрузки событий - окрасить ячейки
                    setTimeout(() => {
                        colorEventCells();
                    }, 100);
                })
                .catch((error) => {
                    console.error("Ошибка загрузки событий:", error);
                    failureCallback(error);
                });
        },

        // Кастомный рендер содержимого дня
        dayCellContent: function (arg) {
            return { html: arg.dayNumberText };
        },

        // Клик по дню - показать popover с событиями
        dateClick: function (info) {
            const events = calendar.getEvents().filter((event) => {
                if (!event.start) return false;
                const eventDate = event.start.toDateString();
                return eventDate === info.date.toDateString();
            });

            if (events.length > 0) {
                showDayEventsPopover(info.dayEl, info.date, events);
            }
        },
    });

    // Функция показа кастомного popover с событиями дня
    function showDayEventsPopover(dayEl, date, events) {
        // Удалить существующий popover если есть
        const existingPopover = document.querySelector(".custom-day-popover");
        if (existingPopover) {
            existingPopover.remove();
        }

        // Создать popover
        const popover = document.createElement("div");
        popover.className = "custom-day-popover";

        // Получить координаты ячейки
        const rect = dayEl.getBoundingClientRect();
        const scrollTop =
            window.pageYOffset || document.documentElement.scrollTop;

        // Форматировать дату
        const day = date.getDate().toString().padStart(2, "0");
        const monthNames = [
            "января",
            "февраля",
            "марта",
            "апреля",
            "мая",
            "июня",
            "июля",
            "августа",
            "сентября",
            "октября",
            "ноября",
            "декабря",
        ];
        const monthYear = `${
            monthNames[date.getMonth()]
        } ${date.getFullYear()}`;

        // Сформировать HTML с событиями
        let eventsHtml = "";
        events.forEach((event) => {
            const time = event.start
                ? event.start.toLocaleTimeString("ru-RU", {
                      hour: "2-digit",
                      minute: "2-digit",
                  })
                : "";

            // Определить период дня по времени начала
            let period = "Утро";
            if (event.start) {
                const hours = event.start.getHours();
                if (hours >= 5 && hours < 11) {
                    period = "Утро";
                } else if (hours >= 11 && hours < 17) {
                    period = "День";
                } else if (hours >= 17 && hours < 23) {
                    period = "Вечер";
                } else {
                    period = "Ночь";
                }
            }
            // Если есть в extendedProps - использовать его (для переопределения)
            period = event.extendedProps.period || period;

            const title = event.title || "";
            const description = event.extendedProps.description || "";
            const eventId = event.id || event.extendedProps.id || "";

            // Проверяем, находимся ли мы в админке
            const isAdmin = window.location.pathname.includes("/admin");
            const clickableClass = isAdmin || !isAdmin ? "event-clickable" : ""; // Всегда кликабельно
            const dataAttr = eventId ? `data-event-id="${eventId}"` : "";

            eventsHtml += `
                <div class="popover-event-item ${clickableClass}" ${dataAttr}>
                    <div class="event-header">
                        <span class="event-period">${period}</span>
                        <span class="event-time">${time}</span>
                    </div>
                    <div class="event-description">${title || description}</div>
                </div>
            `;
        });

        popover.innerHTML = `
            <div class="popover-header-custom">
                <div class="popover-date-left">${day}</div>
                <div class="popover-date-right">${monthYear}</div>
            </div>
            <div class="popover-events">
                ${eventsHtml}
            </div>
        `;

        // Позиционировать popover под ячейкой
        popover.style.position = "absolute";
        popover.style.left = `${rect.left}px`;
        popover.style.top = `${rect.bottom + scrollTop}px`;
        popover.style.zIndex = "1000";

        document.body.appendChild(popover);

        // Добавить обработчики кликов для событий
        const eventItems = popover.querySelectorAll(".event-clickable");
        eventItems.forEach((item) => {
            item.style.cursor = "pointer";
            item.addEventListener("click", function (e) {
                e.stopPropagation();
                const eventId = this.getAttribute("data-event-id");
                if (eventId) {
                    if (window.location.pathname.includes("/admin")) {
                        // В админке - переход на редактирование
                        window.location.href = `/admin/events/${eventId}/edit`;
                    } else {
                        // На публичной странице - открыть модальное окно
                        const event = calendar.getEventById(eventId);
                        if (event) {
                            showEventModal(event);
                            popover.remove(); // Закрыть popover
                        }
                    }
                }
            });
        });

        // Закрыть popover при клике вне его
        setTimeout(() => {
            document.addEventListener("click", function closePopover(e) {
                if (!popover.contains(e.target) && !dayEl.contains(e.target)) {
                    popover.remove();
                    document.removeEventListener("click", closePopover);
                }
            });
        }, 0);
    }

    // Функция показа модального окна с деталями события
    function showEventModal(event) {
        // Удалить существующее модальное окно если есть
        const existingModal = document.getElementById("eventDetailModal");
        if (existingModal) {
            existingModal.remove();
        }

        const time = event.start
            ? event.start.toLocaleTimeString("ru-RU", {
                  hour: "2-digit",
                  minute: "2-digit",
              })
            : "";

        const date = event.start
            ? event.start.toLocaleDateString("ru-RU", {
                  day: "2-digit",
                  month: "long",
                  year: "numeric",
              })
            : "";

        // Определить период дня по времени начала
        let period = "Утро";
        if (event.start) {
            const hours = event.start.getHours();
            if (hours >= 5 && hours < 11) {
                period = "Утро";
            } else if (hours >= 11 && hours < 17) {
                period = "День";
            } else if (hours >= 17 && hours < 23) {
                period = "Вечер";
            } else {
                period = "Ночь";
            }
        }
        // Если есть в extendedProps - использовать его (для переопределения)
        period = event.extendedProps.period || period;

        const title = event.title || "";
        const description = event.extendedProps.description || "";
        const endTime = event.end
            ? event.end.toLocaleTimeString("ru-RU", {
                  hour: "2-digit",
                  minute: "2-digit",
              })
            : "";

        // Создать модальное окно
        const modal = document.createElement("div");
        modal.id = "eventDetailModal";
        modal.className = "event-modal-overlay";
        modal.innerHTML = `
            <div class="event-modal-content">
                <button class="event-modal-close">&times;</button>
                <div class="event-modal-header">
                    <div class="event-modal-date">${date}</div>
                    <div class="event-modal-period-time">
                        <span class="event-modal-period">${period}</span>
                        <span class="event-modal-time">${time}${
            endTime ? " - " + endTime : ""
        }</span>
                    </div>
                </div>
                <div class="event-modal-body">
                    <h3 class="event-modal-title">${title}</h3>
                    <p class="event-modal-description">${
                        description ||
                        "Подробности уточняйте у служителей храма."
                    }</p>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Показать модальное окно с анимацией
        setTimeout(() => {
            modal.classList.add("show");
        }, 10);

        // Закрыть модальное окно
        const closeModal = () => {
            modal.classList.remove("show");
            setTimeout(() => {
                modal.remove();
            }, 300);
        };

        modal
            .querySelector(".event-modal-close")
            .addEventListener("click", closeModal);
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Закрыть по Escape
        const handleEscape = (e) => {
            if (e.key === "Escape") {
                closeModal();
                document.removeEventListener("keydown", handleEscape);
            }
        };
        document.addEventListener("keydown", handleEscape);
    }

    // Функция окрашивания ячеек с событиями
    function colorEventCells() {
        const allCells = document.querySelectorAll(".fc-daygrid-day");
        allCells.forEach((cell) => {
            const dateStr = cell.getAttribute("data-date");
            if (!dateStr) return;

            const cellDate = new Date(dateStr + "T00:00:00");
            const events = calendar.getEvents().filter((event) => {
                if (!event.start) return false;
                const eventDate = new Date(event.start);
                return (
                    eventDate.getFullYear() === cellDate.getFullYear() &&
                    eventDate.getMonth() === cellDate.getMonth() &&
                    eventDate.getDate() === cellDate.getDate()
                );
            });

            const dayFrame = cell.querySelector(".fc-daygrid-day-frame");
            if (dayFrame) {
                if (events.length > 0) {
                    dayFrame.classList.add("has-events");
                    cell.style.cursor = "pointer";
                } else {
                    dayFrame.classList.remove("has-events");
                    cell.style.cursor = "default";
                }
            }
        });
    }

    // Функции модальных окон удалены - используется кастомный popover

    calendar.render();

    // Обработчики для селекторов
    monthSelect.addEventListener("change", function () {
        const year = parseInt(yearSelect.value);
        const month = parseInt(monthSelect.value);
        calendar.gotoDate(new Date(year, month, 1));
        setTimeout(() => colorEventCells(), 100);
    });

    yearSelect.addEventListener("change", function () {
        const year = parseInt(yearSelect.value);
        const month = parseInt(monthSelect.value);
        calendar.gotoDate(new Date(year, month, 1));
        setTimeout(() => colorEventCells(), 100);
    });
});
