import Swiper from "swiper";
import { Navigation, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";

document.addEventListener("DOMContentLoaded", () => {
    try {
        const swiperSelector = ".calendar-swiper";
        const swiperEl = document.querySelector(swiperSelector);

        // Инициализируем Swiper без автозапуска (autoplay отключён)
        const calendarSwiper = new Swiper(swiperSelector, {
            modules: [Navigation, Autoplay],
            spaceBetween: 16,
            slidesPerView: 3,
            loop: true,
            centeredSlides: true,
            initialSlide: 3, // centre on today (start = today - 3 days)
            // Не включаем autoplay по умолчанию — будем запускать через IntersectionObserver
            autoplay: false,
            navigation: {
                nextEl: ".calendar-next",
                prevEl: ".calendar-prev",
            },
            observer: true,
            observeParents: true,
            watchOverflow: true,
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 8 },
                576: { slidesPerView: 2, spaceBetween: 10 },
                768: { slidesPerView: 3, spaceBetween: 12 },
                992: { slidesPerView: 3, spaceBetween: 14 },
                1200: { slidesPerView: 3, spaceBetween: 16 },
            },
        });

        document
            .querySelectorAll(".calendar-prev, .calendar-next")
            .forEach((btn) => {
                btn.classList.add("btn-calendar-nav");
            });

        // Функции управления автоплеем (безопасно — проверяем наличие календаря и autoplay API)
        const startAutoplay = () => {
            if (!calendarSwiper || !calendarSwiper.autoplay) return;
            // Устанавливаем желаемую задержку (3.5s) и поведение при взаимодействии
            calendarSwiper.params.autoplay = {
                delay: 3500,
                disableOnInteraction: false,
            };
            calendarSwiper.autoplay.start();
        };
        const stopAutoplay = () => {
            if (!calendarSwiper || !calendarSwiper.autoplay) return;
            calendarSwiper.autoplay.stop();
        };

        // Запуск автоплея только когда элемент виден (IntersectionObserver)
        if (swiperEl && "IntersectionObserver" in window) {
            let autoplayActivatedOnce = false; // чтобы не переинициализировать params многократно
            const io = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        // Вьюпорт — когда хотя бы половина блока видна
                        if (
                            entry.isIntersecting &&
                            entry.intersectionRatio >= 0.5
                        ) {
                            // Запускаем автоплей; если уже запускали ранее — просто стартуем
                            if (!autoplayActivatedOnce) {
                                startAutoplay();
                                autoplayActivatedOnce = true;
                            } else {
                                // если ранее уже активировали, просто возобновляем (на случай остановки)
                                startAutoplay();
                            }
                        } else {
                            // если блок не виден — останавливаем автоплей
                            stopAutoplay();
                        }
                    });
                },
                { threshold: [0, 0.25, 0.5, 0.75, 1] }
            );
            io.observe(swiperEl);
        } else {
            // fallback: если IntersectionObserver недоступен, просто запускаем автоплей
            startAutoplay();
        }

        // pause autoplay on hover (оставляем поведение)
        if (swiperEl) {
            swiperEl.addEventListener("mouseenter", () => {
                calendarSwiper.autoplay && calendarSwiper.autoplay.stop();
            });
            swiperEl.addEventListener("mouseleave", () => {
                calendarSwiper.autoplay && calendarSwiper.autoplay.start();
            });
        }
    } catch (e) {
        console.error("Calendar swiper init failed", e);
    }
});
