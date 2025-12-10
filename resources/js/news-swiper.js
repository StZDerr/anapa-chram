// Импортируем Swiper + используемые модули
import Swiper from "swiper";
import { Navigation } from "swiper/modules";

// CSS нужных модулей
import "swiper/css";
import "swiper/css/navigation";

// Инициализация Swiper для новостей
const swiper = new Swiper(".swiper-container", {
    modules: [Navigation],

    // Поведение
    passiveListeners: true,
    preloadImages: false,

    // Включаем loop (если хотите зацикливание)
    loop: true,

    // Видимость/группирование
    slidesPerView: 1,
    slidesPerGroup: 1,
    spaceBetween: 10,
    centeredSlides: false,

    // Навигация — привязываем к конкретным кнопкам из шаблона
    navigation: {
        nextEl: ".news-button-next",
        prevEl: ".news-button-prev",
    },

    // Повышаем стабильность при динамическом DOM / изменении размеров
    observer: true,
    observeParents: true,
    watchOverflow: true,

    // Чувствительность тача, минимальный порог — уменьшит ложные срабатывания
    threshold: 5,
    touchRatio: 1,
    touchAngle: 30,
    grabCursor: true,

    // Адаптив
    breakpoints: {
        1199: {
            slidesPerView: 2,
            slidesPerGroup: 1,
            spaceBetween: 25,
        },
        1400: {
            slidesPerView: 3,
            slidesPerGroup: 1,
            spaceBetween: 30,
        },
    },
});
