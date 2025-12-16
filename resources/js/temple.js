// Инициализация галереи с миниатюрами для страницы Temple
import Swiper from "swiper";
import { Navigation, Thumbs, EffectFade } from "swiper/modules";

import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/thumbs";
import "swiper/css/effect-fade";
// ========== ПЕРВАЯ ГАЛЕРЕЯ ==========
// Swiper с миниатюрами (вертикальный на десктопе, горизонтальный на мобильных)
const galleryThumbs = new Swiper(".gallery-thumbs", {
    modules: [Navigation],
    direction: "vertical",
    slidesPerView: 3,
    spaceBetween: 10,
    watchSlidesProgress: true,
    slideToClickedSlide: true,
    navigation: {
        nextEl: ".gallery-thumbs .swiper-button-next",
        prevEl: ".gallery-thumbs .swiper-button-prev",
    },
    breakpoints: {
        // Mobile: horizontal layout
        320: {
            direction: "horizontal",
            slidesPerView: "auto",
            spaceBetween: 10,
        },
        // Desktop: vertical layout
        992: {
            direction: "vertical",
            slidesPerView: 3,
            spaceBetween: 10,
        },
    },
});

// Основной Swiper с большими изображениями
const galleryTop = new Swiper(".gallery-top", {
    modules: [Navigation, Thumbs, EffectFade],
    thumbs: { swiper: galleryThumbs },
    spaceBetween: 10,
    navigation: {
        nextEl: ".gallery-top-next",
        prevEl: ".gallery-top-prev",
    },
    thumbs: {
        swiper: galleryThumbs,
    },
    loop: false,
    effect: "fade",
    fadeEffect: {
        crossFade: true,
    },
});

// ========== ВТОРАЯ ГАЛЕРЕЯ ==========
// Swiper с миниатюрами для второй галереи (вертикальный на десктопе, горизонтальный на мобильных)
const galleryThumbs2 = new Swiper(".gallery-thumbs-2", {
    modules: [Navigation],
    direction: "vertical",
    slidesPerView: 3,
    spaceBetween: 10,
    watchSlidesProgress: true,
    slideToClickedSlide: true,
    navigation: {
        nextEl: ".gallery-thumbs-2 .swiper-button-next",
        prevEl: ".gallery-thumbs-2 .swiper-button-prev",
    },
    breakpoints: {
        // Mobile: horizontal layout
        320: {
            direction: "horizontal",
            slidesPerView: "auto",
            spaceBetween: 10,
        },
        // Desktop: vertical layout
        992: {
            direction: "vertical",
            slidesPerView: 3,
            spaceBetween: 10,
        },
    },
});

// Основной Swiper для второй галереи
const galleryTop2 = new Swiper(".gallery-top-2", {
    modules: [Navigation, Thumbs, EffectFade],
    thumbs: { swiper: galleryThumbs },

    spaceBetween: 10,
    navigation: {
        nextEl: ".gallery-top-2-next",
        prevEl: ".gallery-top-2-prev",
    },
    thumbs: {
        swiper: galleryThumbs2,
    },
    loop: false,
    effect: "fade",
    fadeEffect: {
        crossFade: true,
    },
});
