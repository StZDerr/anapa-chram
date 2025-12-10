// photo-section.js — self-contained module for gallery/PhotoSwipe
import Swiper from "swiper";
import { Navigation } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";

import PhotoSwipeLightbox from "photoswipe/lightbox";
import PhotoSwipe from "photoswipe";
import "photoswipe/style.css";

document.addEventListener("DOMContentLoaded", () => {
    // Динамическая инициализация всех Swiper'ов в галереях
    const initAllSwipers = () => {
        document
            .querySelectorAll(".gallery-instance .gallery-swiper")
            .forEach((swiperEl) => {
                if (swiperEl.swiper) {
                    // Уже инициализирован
                    return;
                }

                // Находим имя категории из класса (gallery-{slug}-swiper)
                const classList = Array.from(swiperEl.classList);
                const categoryClass = classList.find(
                    (cls) =>
                        cls.startsWith("gallery-") &&
                        cls.endsWith("-swiper") &&
                        cls !== "gallery-swiper"
                );

                if (!categoryClass) return;

                const slug = categoryClass
                    .replace("gallery-", "")
                    .replace("-swiper", "");
                const prevSelector = `.gallery-${slug}-prev`;
                const nextSelector = `.gallery-${slug}-next`;

                new Swiper(swiperEl, {
                    modules: [Navigation],
                    passiveListeners: true,
                    slidesPerView: 3,
                    spaceBetween: 24,
                    loop: false,
                    allowTouchMove: true,
                    observer: true,
                    observeParents: true,
                    navigation: {
                        nextEl: nextSelector,
                        prevEl: prevSelector,
                    },
                    breakpoints: {
                        320: { slidesPerView: 1, spaceBetween: 16 },
                        768: { slidesPerView: 2, spaceBetween: 20 },
                        1200: { slidesPerView: 3, spaceBetween: 24 },
                    },
                });
            });
    };

    // Инициализируем все свайперы при загрузке
    initAllSwipers();

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
                // Обновляем Swiper после показа галереи
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
    try {
        const lightbox = new PhotoSwipeLightbox({
            gallery: ".gallery-swiper",
            children: "a",
            pswpModule: PhotoSwipe,
            showHideAnimationType: "zoom",
            bgOpacity: 0.95,
            padding: { top: 50, bottom: 50, left: 50, right: 50 },
        });
        lightbox.init();
    } catch (e) {
        console.error("PhotoSwipe init failed:", e);
    }
});
