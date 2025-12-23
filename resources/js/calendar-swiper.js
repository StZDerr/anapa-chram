import Swiper from "swiper";
import { Navigation } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";

document.addEventListener("DOMContentLoaded", () => {
    const swiperSelector = ".calendar-swiper";
    const swiperEl = document.querySelector(swiperSelector);

    const calendarSwiper = new Swiper(swiperSelector, {
        modules: [Navigation],
        spaceBetween: 16,
        slidesPerView: 3,
        loop: true,
        centeredSlides: true,
        initialSlide: 3,
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
        .forEach((btn) => btn.classList.add("btn-calendar-nav"));
});
