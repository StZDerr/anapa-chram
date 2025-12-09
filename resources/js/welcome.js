document.addEventListener("DOMContentLoaded", () => {
    try {
        const activeBtn = document.querySelector(".nav-link.day-circle.active");
        if (activeBtn && window.bootstrap) {
            const tab = window.bootstrap.Tab.getOrCreateInstance(activeBtn);
            tab.show();
        }
    } catch (e) {
        // безопасно логируем, но не ломаем страницу
        console.error("Welcome tab activation failed", e);
    }
});
// Импортируем Swiper
import Swiper from "swiper";
import { Navigation, Pagination, FreeMode, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/free-mode";

// Импортируем PhotoSwipe
import PhotoSwipeLightbox from "photoswipe/lightbox";
import PhotoSwipe from "photoswipe";
import "photoswipe/style.css";

document.addEventListener("DOMContentLoaded", () => {
    // Инициализация табов расписания
    const days = document.querySelectorAll(".day-circle");
    days.forEach((day) => {
        day.addEventListener("shown.bs.tab", () => {
            days.forEach((d) => {
                d.textContent = d.dataset.short;
            });
            day.textContent = day.dataset.full;
        });
    });

    const active = document.querySelector(".day-circle.active");
    if (active) active.textContent = active.dataset.full;

    // Первый Swiper - Новости
    const swiper = new Swiper(".swiper-container", {
        modules: [Navigation],
        passiveListeners: true,
        lazy: true,
        preloadImages: false,
        loop: true,
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 10,
        centeredSlides: false,
        watchOverflow: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            1199: {
                slidesPerView: 2,
                slidesPerGroup: 1,
                spaceBetween: 25,
            },
            1400: {
                slidesPerView: 3,
                slidesPerGroup: 1,
                spaceBetween: 30,
            },
        },
    });

    // Второй Swiper - Деятельность храма
    const activitySwiper = new Swiper(".activity-swiper-container", {
        modules: [Pagination],
        passiveListeners: true,
        slideToClickedSlide: true,
        lazy: true,
        preloadImages: false,
        loop: true,
        slidesPerView: 1,
        centeredSlides: true,
        spaceBetween: 30,
        effect: "slide",
        watchSlidesProgress: true,
        pagination: {
            el: ".activity-pagination",
            clickable: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 15,
                centeredSlides: true,
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 20,
                centeredSlides: true,
            },
            1024: {
                slidesPerView: 2,
                spaceBetween: 25,
                centeredSlides: true,
            },
            1400: {
                slidesPerView: 3,
                spaceBetween: 30,
                centeredSlides: true,
            },
        },
    });

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

    // Галереи в разделе ФОТОГАЛЕРЕЯ
    // Инициализация трёх Swiper'ов по категориям
    const templeSwiper = new Swiper(".gallery-temple-swiper", {
        modules: [Navigation],
        passiveListeners: true,
        lazy: true,
        preloadImages: false,
        slidesPerView: 3,
        spaceBetween: 24,
        loop: false,
        allowTouchMove: true,
        observer: true,
        observeParents: true,
        navigation: {
            nextEl: ".gallery-temple-next",
            prevEl: ".gallery-temple-prev",
        },
        breakpoints: {
            320: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1200: { slidesPerView: 3 },
        },
    });

    const festivalsSwiper = new Swiper(".gallery-festivals-swiper", {
        modules: [Navigation],
        passiveListeners: true,
        slidesPerView: 3,
        spaceBetween: 24,
        loop: false,
        allowTouchMove: true,
        observer: true,
        observeParents: true,
        navigation: {
            nextEl: ".gallery-festivals-next",
            prevEl: ".gallery-festivals-prev",
        },
        breakpoints: {
            320: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1200: { slidesPerView: 3 },
        },
    });

    const parkSwiper = new Swiper(".gallery-park-swiper", {
        modules: [Navigation],
        passiveListeners: true,
        slidesPerView: 3,
        spaceBetween: 24,
        loop: false,
        allowTouchMove: true,
        observer: true,
        observeParents: true,
        navigation: {
            nextEl: ".gallery-park-next",
            prevEl: ".gallery-park-prev",
        },
        breakpoints: {
            320: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1200: { slidesPerView: 3 },
        },
    });

    // Переключение галерей по кнопкам
    document.querySelectorAll(".photo-filters .btn-filter").forEach((btn) => {
        btn.addEventListener("click", () => {
            document
                .querySelectorAll(".photo-filters .btn-filter")
                .forEach((b) => b.classList.remove("active"));
            btn.classList.add("active");
            const target = btn.dataset.target;
            document
                .querySelectorAll(".gallery-instance")
                .forEach((inst) => inst.classList.add("d-none"));
            const el = document.querySelector(target);
            if (el) {
                el.classList.remove("d-none");
                // Обновляем Swiper после показа галереи (избегаем forced reflow)
                requestAnimationFrame(() => {
                    const swiperEl = el.querySelector(".swiper");
                    if (swiperEl && swiperEl.swiper) {
                        swiperEl.swiper.update();
                    }
                });
            }
        });
    });

    // Инициализация PhotoSwipe Lightbox (v5) для всех ссылок внутри .gallery-swiper
    const lightbox = new PhotoSwipeLightbox({
        gallery: ".gallery-swiper",
        children: "a",
        pswpModule: PhotoSwipe,
        // UI элементы: крестик закрытия, кнопки зума, счётчик
        showHideAnimationType: "zoom",
        bgOpacity: 0.95,
        padding: { top: 50, bottom: 50, left: 50, right: 50 },
    });
    lightbox.init();
    (function animateWindows() {
        const windows = document.querySelectorAll(
            ".background-container .window"
        );
        if (!windows || windows.length === 0) return;

        // задаём начальное состояние (на случай, если CSS не успел подгрузиться)
        windows.forEach((w) => {
            w.classList.remove("window--enter");
            w.style.willChange = "transform, opacity";
        });

        // небольшой таймаут чтобы дать браузеру отрисовать начальное состояние
        // затем включаем класс с задержками
        setTimeout(() => {
            windows.forEach((w, i) => {
                // задержка по индексу (stagger)
                const delay = i * 120; // ms — можно увеличить/уменьшить
                setTimeout(() => {
                    w.classList.add("window--enter");
                }, delay);
            });
        }, 100); // даём 100ms после DOM ready
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

        if ("IntersectionObserver" in window) {
            const io = new IntersectionObserver(
                (entries, observer) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            trigger();
                            observer.disconnect();
                        }
                    });
                },
                { threshold: 0.15 }
            );
            io.observe(el);
        } else {
            setTimeout(trigger, 350);
        }
    })();
});
