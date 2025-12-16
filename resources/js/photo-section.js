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

        // Подставляем размеры (data-pswp-width/height) из внутренних изображений, если возможно
        document.querySelectorAll(".gallery-swiper a").forEach((a) => {
            const img = a.querySelector("img");
            if (!img) return;
            const setSize = () => {
                a.setAttribute(
                    "data-pswp-width",
                    img.naturalWidth || img.width
                );
                a.setAttribute(
                    "data-pswp-height",
                    img.naturalHeight || img.height
                );
            };
            if (img.complete) setSize();
            else img.addEventListener("load", setSize);
        });

        // Добавляем кастомную кнопку закрытия для всех галерей (вставляется в top-bar)
        lightbox.on("uiRegister", function () {
            lightbox.pswp.ui.registerElement({
                name: "custom-close-button",
                order: 9,
                isButton: true,
                appendTo: "top-bar",
                html:
                    '<button class="pswp__button pswp__button--custom-close-button" title="Закрыть">' +
                    '<span class="pswp__icn">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>' +
                    "</span>" +
                    "</button>",
                onClick: "close",
            });
        });

        lightbox.init();
    } catch (e) {
        console.error("PhotoSwipe init failed:", e);
    }
});
