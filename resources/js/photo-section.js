// photo-section.js — self-contained module for gallery/PhotoSwipe
import Swiper from "swiper";
import { Navigation } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";

import PhotoSwipeLightbox from "photoswipe/lightbox";
import PhotoSwipe from "photoswipe";
import "photoswipe/style.css";

document.addEventListener("DOMContentLoaded", () => {
    // Инициализация Swiper для парка (и других — ниже)
    const parkSwiperEl = document.querySelector(".gallery-park-swiper");
    if (parkSwiperEl) {
        new Swiper(parkSwiperEl, {
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
    }

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
});
