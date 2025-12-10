// Импортируем Swiper
import Swiper from "swiper";
import { FreeMode } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/free-mode";

// Импортируем PhotoSwipe
import PhotoSwipeLightbox from "photoswipe/lightbox";
import PhotoSwipe from "photoswipe";
import "photoswipe/style.css";

document.addEventListener("DOMContentLoaded", () => {
    // Функция для определения типа отображения (мобильный/десктоп)
    const isMobile = () => window.innerWidth < 768;

    // Функция обновления текста дней недели
    const updateDayLabels = () => {
        const days = document.querySelectorAll(".day-circle");
        days.forEach((day) => {
            if (isMobile()) {
                // На мобильных всегда показываем короткие названия
                day.textContent = day.dataset.short;
            } else {
                // На десктопе: активная кнопка — полное название, остальные — короткие
                day.textContent = day.classList.contains("active")
                    ? day.dataset.full
                    : day.dataset.short;
            }
        });
    };

    // Инициализация табов расписания
    const days = document.querySelectorAll(".day-circle");
    days.forEach((day) => {
        day.addEventListener("shown.bs.tab", () => {
            if (!isMobile()) {
                // На десктопе меняем текст: активная — полное имя
                days.forEach((d) => {
                    d.textContent = d.dataset.short;
                });
                day.textContent = day.dataset.full;
            }
            // На мобильных текст не меняется (всегда короткие названия)
        });
    });

    // Устанавливаем начальное состояние
    updateDayLabels();

    // Обновляем при изменении размера окна
    let resizeTimer;
    window.addEventListener("resize", () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(updateDayLabels, 150);
    });

    // Активация таба для начального активного дня
    try {
        const activeBtn = document.querySelector(".nav-link.day-circle.active");
        if (activeBtn && window.bootstrap) {
            const tab = window.bootstrap.Tab.getOrCreateInstance(activeBtn);
            tab.show();
        }
    } catch (e) {
        console.error("Welcome tab activation failed", e);
    }

    // Третий Swiper - Галерея храма (раскрывающиеся карточки)
    const gallerySwiper = new Swiper(".mySwiper", {
        modules: [FreeMode],
        passiveListeners: true,
        lazy: true,
        preloadImages: false,
        slidesPerView: "auto",
        spaceBetween: 10,
        grabCursor: true,
        freeMode: false,
        allowTouchMove: false,
        simulateTouch: false,
    });

    // Обработка кликов для активации слайдов в галерее
    const mySwiperEl = document.querySelector(".mySwiper");
    if (mySwiperEl) {
        mySwiperEl.addEventListener("click", (e) => {
            const slide = e.target.closest(".swiper-slide");
            if (!slide) return;
            const active = e.currentTarget.querySelector(
                ".swiper-slide.active"
            );
            if (active) active.classList.remove("active");
            slide.classList.add("active");
        });
    }
});

// Анимации запускаются после загрузки изображений (после loader)
window.addEventListener("loader:imagesReady", () => {
    // Анимация окошек (windows) - появляются сверху вниз с задержкой
    (function animateWindows() {
        const windows = document.querySelectorAll(
            ".background-container .window"
        );
        if (!windows || windows.length === 0) return;

        // Убеждаемся что начальное состояние установлено
        windows.forEach((w) => {
            w.classList.remove("window--enter");
            w.style.willChange = "transform, opacity";
        });

        // Запускаем анимацию с задержкой для каждого окна (stagger effect)
        setTimeout(() => {
            windows.forEach((w, i) => {
                const delay = i * 150; // задержка между окнами (ms)
                setTimeout(() => {
                    w.classList.add("window--enter");
                }, delay);
            });
        }, 200); // начинаем через 200ms после исчезновения loader
    })();

    // Плавная анимация для основного текстового блока
    (function animateMainText() {
        const el = document.querySelector(".main-text-block");
        if (!el) return;

        const trigger = () => {
            if (!el.classList.contains("animate")) {
                el.classList.add("animate");
            }
        };

        // Запускаем анимацию текста через 400ms после начала анимации окон
        setTimeout(trigger, 600);
    })();
});
