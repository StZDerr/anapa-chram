import Swiper from "swiper";
import { Navigation, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";

document.addEventListener("DOMContentLoaded", () => {
    try {
        const calendarSwiper = new Swiper(".calendar-swiper", {
            modules: [Navigation, Autoplay],
            spaceBetween: 16,
            slidesPerView: 3,
            loop: true,
            centeredSlides: true,
            initialSlide: 3, // centre on today (start = today - 3 days)
            autoplay: {
                delay: 1500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".calendar-next",
                prevEl: ".calendar-prev",
            },
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
        // pause autoplay on hover
        const swiperEl = document.querySelector(".calendar-swiper");
        if (swiperEl) {
            swiperEl.addEventListener(
                "mouseenter",
                () => calendarSwiper.autoplay && calendarSwiper.autoplay.stop()
            );
            swiperEl.addEventListener(
                "mouseleave",
                () => calendarSwiper.autoplay && calendarSwiper.autoplay.start()
            );
        }
    } catch (e) {
        console.error("Calendar swiper init failed", e);
    }
});
