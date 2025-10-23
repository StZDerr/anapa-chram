// Импортируем Swiper
import Swiper from "swiper";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

// Импортируем PhotoSwipe
import PhotoSwipeLightbox from "photoswipe/lightbox";
import PhotoSwipe from "photoswipe";
import "photoswipe/style.css";

document.addEventListener("DOMContentLoaded", () => {
    // Swiper для фотогалереи
    const newsGallerySwiper = new Swiper(".newsGallerySwiper", {
        modules: [Navigation, Pagination, Autoplay],
        passiveListeners: true,
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".newsGallerySwiper .swiper-button-next",
            prevEl: ".newsGallerySwiper .swiper-button-prev",
        },
        pagination: {
            el: ".newsGallerySwiper .swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 15,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
        },
    });

    // PhotoSwipe для lightbox галереи
    const lightbox = new PhotoSwipeLightbox({
        gallery: ".newsGallerySwiper",
        children: "a",
        pswpModule: PhotoSwipe,
        bgOpacity: 0.98,
        zoom: true,
        close: true,
        arrowKeys: true,
        closeOnVerticalDrag: true,
        pinchToClose: true,
        padding: { top: 50, bottom: 50, left: 50, right: 50 },
        tapAction: false,
        doubleTapAction: "zoom",
        preload: [1, 2],
    });

    // Добавляем кастомную кнопку закрытия
    lightbox.on("uiRegister", function () {
        lightbox.pswp.ui.registerElement({
            name: "custom-close-button",
            order: 9,
            isButton: true,
            html: '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
            onClick: "close",
        });
    });

    lightbox.init();

    // Плавная прокрутка к якорям
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            const href = this.getAttribute("href");
            if (href !== "#" && document.querySelector(href)) {
                e.preventDefault();
                document.querySelector(href).scrollIntoView({
                    behavior: "smooth",
                });
            }
        });
    });

    // Анимация появления элементов при скролле (удалены неиспользуемые селекторы)
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            }
        });
    }, observerOptions);

    // Применяем анимацию только к существующим элементам
    const animatedElements = document.querySelectorAll(".news-article p");

    animatedElements.forEach((el) => {
        el.style.opacity = "0";
        el.style.transform = "translateY(30px)";
        el.style.transition = "opacity 0.6s ease, transform 0.6s ease";
        observer.observe(el);
    });
});
