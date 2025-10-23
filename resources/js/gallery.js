document.addEventListener("DOMContentLoaded", () => {
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
            }
        });
    });

    // Инициализация PhotoSwipe Lightbox (v5)
    if (typeof PhotoSwipeLightbox !== "undefined") {
        const lightbox = new PhotoSwipeLightbox({
            gallery: ".gallery-grid",
            children: "a",
            pswpModule: PhotoSwipe,
            showHideAnimationType: "zoom",
            bgOpacity: 0.95,
            padding: { top: 50, bottom: 50, left: 50, right: 50 },
        });
        lightbox.init();
    }
});
