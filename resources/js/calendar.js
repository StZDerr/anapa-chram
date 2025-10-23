import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("calendar");

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        locale: "ru",
        initialView: "timeGridWeek",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        dayHeaderContent: function (arg) {
            const dateStr = arg.date.toLocaleDateString("ru-RU", {
                day: "numeric",
                month: "short",
            });
            const weekdayStr = arg.date
                .toLocaleDateString("ru-RU", { weekday: "short" })
                .toUpperCase();
            return dateStr + weekdayStr;
        },
        slotLabelFormat: {
            hour: "numeric",
            minute: "2-digit",
            hour12: false,
        },
        events: "/api/calendar/events",
        eventClick: function (info) {
            alert(
                "Событие: " +
                    info.event.title +
                    "\nОписание: " +
                    (info.event.extendedProps.description || "Нет описания")
            );
        },
        height: "auto",
        aspectRatio: 1.5,
        nowIndicator: true,
        scrollTime: "08:00:00",
    });

    calendar.render();
});
