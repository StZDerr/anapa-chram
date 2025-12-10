// Инициализация галереи с миниатюрами для страницы Temple

// ========== ПЕРВАЯ ГАЛЕРЕЯ ==========
// Swiper с миниатюрами (вертикальный на десктопе, горизонтальный на мобильных)
const galleryThumbs = new Swiper(".gallery-thumbs", {
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

// Второй Swiper - Деятельность храма
const activitySwiper = new Swiper(".activity-swiper-container", {
    slideToClickedSlide: true,
    lazy: true,
    preloadImages: false,
    loop: true,
    slidesPerView: 1,
    centeredSlides: true,
    spaceBetween: 30,
    effect: "slide",
    watchSlidesProgress: true,
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

// ========== ФОТОГАЛЕРЕЯ ==========
// Галереи по категориям
// Инициализация трёх Swiper'ов по категориям
const templeSwiper = new Swiper(".gallery-temple-swiper", {
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

const parkSwiper = new Swiper(".gallery-park-swiper", {
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
            // Обновляем Swiper после показа галереи (избегаем forced reflow)
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
if (typeof PhotoSwipeLightbox !== "undefined") {
    const lightbox = new PhotoSwipeLightbox({
        gallery: ".gallery-swiper",
        children: "a",
        pswpModule: PhotoSwipe,
        // UI элементы: крестик закрытия, кнопки зума, счётчик
        showHideAnimationType: "zoom",
        bgOpacity: 0.95,
        padding: { top: 50, bottom: 50, left: 50, right: 50 },
    });
    lightbox.init();
}
