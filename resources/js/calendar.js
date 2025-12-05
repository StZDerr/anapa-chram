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
        // dayMaxEventRows: true,
        dayMaxEvents: 2, // Показывать максимум 2 события, остальные скрыть под "+N"

        moreLinkContent: function (args) {
            return `+ещё ${args.num}`;
        },

        // Загрузка событий из API
        events: function (fetchInfo, successCallback, failureCallback) {
            const apiUrl = window.CALENDAR_EVENTS_URL || "/api/calendar/events";
            fetch(apiUrl)
                .then((response) => response.json())
                .then((data) => {
                    successCallback(data);
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

        // Кастомный рендер события
        eventContent: function (arg) {
            if (!arg.event.start) return { html: "" };

            const time = arg.event.start.toLocaleTimeString("ru-RU", {
                hour: "2-digit",
                minute: "2-digit",
            });

            return {
                html: `<div class="event-time-only">${time}</div>`,
            };
        },

        // Клик по событию
        eventClick: function (info) {
            info.jsEvent.preventDefault();
            console.log("Клик по событию:", info.event);
            console.log(
                "Bootstrap доступен:",
                typeof bootstrap !== "undefined"
            );
            showEventModal(info.event);
        },

        // Клик по кнопке "+N событий" - показать все события
        moreLinkClick: function (info) {
            return "popover"; // показать всплывающее окно со всеми событиями
        },

        // Клик по дню - показать все события дня
        dateClick: function (info) {
            const events = calendar.getEvents().filter((event) => {
                const eventDate = event.start.toDateString();
                return eventDate === info.date.toDateString();
            });

            if (events.length > 0) {
                showDayEventsModal(info.date, events);
            }
        },
    });

    // Функция показа модального окна для события
    function showEventModal(event) {
        console.log("showEventModal вызвана для события:", event.title);

        const modal =
            document.getElementById("eventModal") || createEventModal();
        console.log("Модальное окно:", modal);

        document.getElementById("eventModalTitle").textContent = event.title;
        document.getElementById("eventModalStart").textContent = event.start
            ? event.start.toLocaleString("ru-RU", {
                  year: "numeric",
                  month: "long",
                  day: "numeric",
                  hour: "2-digit",
                  minute: "2-digit",
              })
            : "Не указано";

        document.getElementById("eventModalEnd").textContent = event.end
            ? event.end.toLocaleString("ru-RU", {
                  year: "numeric",
                  month: "long",
                  day: "numeric",
                  hour: "2-digit",
                  minute: "2-digit",
              })
            : "—";

        document.getElementById("eventModalDescription").textContent =
            event.extendedProps.description || "Описание отсутствует";

        // Проверка доступности Bootstrap
        if (typeof bootstrap === "undefined") {
            console.error("Bootstrap не загружен!");
            alert(
                "Ошибка: Bootstrap не загружен. Проверьте подключение скриптов."
            );
            return;
        }

        try {
            const bsModal = new bootstrap.Modal(modal);
            console.log("Bootstrap Modal создан:", bsModal);
            bsModal.show();
        } catch (error) {
            console.error("Ошибка при показе модального окна:", error);
            alert("Ошибка при открытии модального окна: " + error.message);
        }
    }

    // Функция показа модального окна для всех событий дня
    function showDayEventsModal(date, events) {
        const modal =
            document.getElementById("dayEventsModal") || createDayEventsModal();

        const dateStr = date.toLocaleDateString("ru-RU", {
            year: "numeric",
            month: "long",
            day: "numeric",
        });

        document.getElementById(
            "dayEventsModalTitle"
        ).textContent = `События на ${dateStr}`;

        const eventsList = document.getElementById("dayEventsList");
        eventsList.innerHTML = "";

        events.forEach((event) => {
            const eventItem = document.createElement("div");
            eventItem.className = "list-group-item list-group-item-action";
            eventItem.style.cursor = "pointer";
            eventItem.innerHTML = `
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">${event.title}</h6>
                    <small>${
                        event.start
                            ? event.start.toLocaleTimeString("ru-RU", {
                                  hour: "2-digit",
                                  minute: "2-digit",
                              })
                            : ""
                    }</small>
                </div>
                ${
                    event.extendedProps.description
                        ? `<p class="mb-1 text-muted small">${event.extendedProps.description}</p>`
                        : ""
                }
            `;
            eventItem.addEventListener("click", () => {
                bootstrap.Modal.getInstance(modal).hide();
                showEventModal(event);
            });
            eventsList.appendChild(eventItem);
        });

        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    // Создание модального окна для события
    function createEventModal() {
        const modalHtml = `
            <div class="modal fade" id="eventModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventModalTitle"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <strong>Начало:</strong>
                                <div id="eventModalStart"></div>
                            </div>
                            <div class="mb-3">
                                <strong>Окончание:</strong>
                                <div id="eventModalEnd"></div>
                            </div>
                            <div class="mb-3">
                                <strong>Описание:</strong>
                                <div id="eventModalDescription"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML("beforeend", modalHtml);
        return document.getElementById("eventModal");
    }

    // Создание модального окна для списка событий дня
    function createDayEventsModal() {
        const modalHtml = `
            <div class="modal fade" id="dayEventsModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="dayEventsModalTitle"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="list-group" id="dayEventsList"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML("beforeend", modalHtml);
        return document.getElementById("dayEventsModal");
    }

    calendar.render();

    // Обработчики для селекторов
    monthSelect.addEventListener("change", function () {
        const year = parseInt(yearSelect.value);
        const month = parseInt(monthSelect.value);
        calendar.gotoDate(new Date(year, month, 1));
    });

    yearSelect.addEventListener("change", function () {
        const year = parseInt(yearSelect.value);
        const month = parseInt(monthSelect.value);
        calendar.gotoDate(new Date(year, month, 1));
    });
});
