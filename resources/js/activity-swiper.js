// Импортируем Swiper
import Swiper from "swiper";
import { Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/free-mode";

// Второй Swiper - Деятельность храма
const activitySwiper = new Swiper(".activity-swiper-container .swiper", {
    modules: [Pagination],
    initialSlide: 1,
    passiveListeners: true,
    slideToClickedSlide: true,
    lazy: true,
    preloadImages: false,
    loop: false,
    slidesPerView: 1,
    centeredSlides: true,
    spaceBetween: 30,
    effect: "slide",
    watchSlidesProgress: true,
    loopedSlides: 3,
    loopAdditionalSlides: 1,
    threshold: 10,
    touchRatio: 1,
    touchAngle: 45,
    grabCursor: true,
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
