document.addEventListener("DOMContentLoaded", () => {
    // Третий Swiper - Галерея храма (раскрывающиеся карточки)
    const gallerySwiper = new Swiper(".mySwiper", {
        lazy: true,
        preloadImages: false,
        slidesPerView: "auto",
        spaceBetween: 10,
        grabCursor: true,
        freeMode: false,
        allowTouchMove: false,
        simulateTouch: false,
    });

    // Обработка кликов для активации слайдов в галерее
    const mySwiperEl = document.querySelector(".mySwiper");
    if (mySwiperEl) {
        mySwiperEl.addEventListener("click", (e) => {
            const slide = e.target.closest(".swiper-slide");
            if (!slide) return;
            const active = e.currentTarget.querySelector(
                ".swiper-slide.active"
            );
            if (active) active.classList.remove("active");
            slide.classList.add("active");
        });
    }

    // Swiper для достопримечательностей
    const attractionsSwiper = new Swiper(".attractionsSwiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: false,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 1,
                spaceBetween: 30,
            },
        },
    });

    // Предотвращаем конфликт между вертикальным скроллом и горизонтальными свайпами
    const rowElements = document.querySelectorAll(
        ".attractionsSwiper .swiper-slide .row"
    );
    rowElements.forEach((row) => {
        let touchStartY = 0;

        row.addEventListener("touchstart", (e) => {
            touchStartY = e.touches[0].clientY;
        });

        row.addEventListener("touchmove", (e) => {
            const scrollTop = row.scrollTop;
            const scrollHeight = row.scrollHeight;
            const height = row.clientHeight;
            const touchCurrentY = e.touches[0].clientY;
            const touchDiff = touchCurrentY - touchStartY;

            // Проверяем, есть ли место для вертикального скролла
            if (scrollHeight > height) {
                // Скролл вниз (touchDiff < 0) и не достигли низа
                // или скролл вверх (touchDiff > 0) и не достигли верха
                if (
                    (touchDiff < 0 && scrollTop + height < scrollHeight) ||
                    (touchDiff > 0 && scrollTop > 0)
                ) {
                    // Останавливаем всплытие события для предотвращения свайпа
                    e.stopPropagation();
                }
            }
        });
    });

    // ========== ГАЛЕРЕЯ СТРОИТЕЛЬСТВА ХРАМА ==========
    // Swiper с миниатюрами (вертикальный на десктопе, горизонтальный на мобильных)
    const constructionGalleryThumbs = new Swiper(
        ".construction-gallery-thumbs",
        {
            direction: window.innerWidth > 991 ? "vertical" : "horizontal",
            slidesPerView: 4,
            spaceBetween: 10,
            watchSlidesProgress: true,
            slideToClickedSlide: true,
        }
    );

    // Основной Swiper с большими изображениями
    const constructionGalleryTop = new Swiper(".construction-gallery-top", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".construction-gallery-top .swiper-button-next",
            prevEl: ".construction-gallery-top .swiper-button-prev",
        },
        thumbs: {
            swiper: constructionGalleryThumbs,
        },
        loop: false,
        effect: "fade",
        fadeEffect: {
            crossFade: true,
        },
    });

    // Изменение направления превью при ресайзе
    window.addEventListener("resize", () => {
        if (constructionGalleryThumbs) {
            const newDirection =
                window.innerWidth > 991 ? "vertical" : "horizontal";
            if (constructionGalleryThumbs.params.direction !== newDirection) {
                constructionGalleryThumbs.changeDirection(newDirection);
            }
        }
    });
});
