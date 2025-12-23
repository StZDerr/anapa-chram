import Swiper from "swiper";
import { Navigation, Thumbs } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/thumbs";

document.addEventListener("DOMContentLoaded", () => {
    console.log("treby-show init"); // временный лог для отладки

    const topEl = document.querySelector(".treby-gallery-top");
    const thumbsEl = document.querySelector(".treby-gallery-thumbs");

    if (!topEl || !thumbsEl) {
        console.log("treby-show: селекторы не найдены");
        return;
    }

    const thumbs = new Swiper(".treby-gallery-thumbs", {
        modules: [Thumbs],
        direction: window.innerWidth > 991 ? "vertical" : "horizontal",
        slidesPerView: 4,
        spaceBetween: 10,
        watchSlidesProgress: true,
        slideToClickedSlide: true,
    });

    const top = new Swiper(".treby-gallery-top", {
        modules: [Navigation, Thumbs],
        spaceBetween: 10,
        navigation: {
            nextEl: ".treby-gallery-top .swiper-button-next",
            prevEl: ".treby-gallery-top .swiper-button-prev",
        },
        thumbs: { swiper: thumbs },
        loop: false,
        effect: "fade",
        fadeEffect: { crossFade: true },
    });

    window.addEventListener("resize", () => {
        const newDirection =
            window.innerWidth > 991 ? "vertical" : "horizontal";
        if (thumbs && thumbs.params.direction !== newDirection) {
            thumbs.changeDirection(newDirection);
        }
    });
});
