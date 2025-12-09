(function () {
    // Preload background images used in .window elements and show page when ready
    function getBackgroundUrl(el) {
        const inline = el.style && el.style.backgroundImage;
        const computed = window.getComputedStyle
            ? window.getComputedStyle(el).backgroundImage
            : inline;
        const val = inline && inline !== "" ? inline : computed;
        if (!val || val === "none") return null;
        // val looks like: url("/images/...") or url(/images/...)
        const m = /url\(["']?(.+?)["']?\)/.exec(val);
        return m ? m[1] : null;
    }

    function preload(urls, timeout = 5000) {
        return new Promise((resolve) => {
            if (!urls || urls.length === 0) return resolve();
            let loaded = 0;
            let done = false;
            const total = urls.length;
            const timer = setTimeout(() => {
                if (done) return;
                done = true;
                resolve();
            }, timeout);

            urls.forEach((src) => {
                try {
                    const img = new Image();
                    img.onload = img.onerror = function () {
                        if (done) return;
                        loaded++;
                        if (loaded >= total) {
                            clearTimeout(timer);
                            done = true;
                            resolve();
                        }
                    };
                    // start load
                    img.src = src;
                } catch (e) {
                    // ignore
                    loaded++;
                    if (loaded >= total && !done) {
                        clearTimeout(timer);
                        done = true;
                        resolve();
                    }
                }
            });
        });
    }

    function createOverlay() {
        const overlay = document.createElement("div");
        overlay.id = "page-loader";
        overlay.innerHTML =
            '<div class="loader-spinner" aria-hidden="true"></div>';
        document.body.appendChild(overlay);
        return overlay;
    }

    function removeOverlay(overlay) {
        if (!overlay) return;
        overlay.classList.add("hidden");
        setTimeout(() => {
            if (overlay.parentNode) overlay.parentNode.removeChild(overlay);
        }, 400);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const overlay = createOverlay();
        const windows = Array.from(document.querySelectorAll(".window"));
        const urls = windows.map(getBackgroundUrl).filter(Boolean);
        // If inline style used with Laravel asset(), it will be absolute URL already
        preload(Array.from(new Set(urls))).then(() => {
            // mark page as loaded
            document.body.classList.add("page-loaded");
            // small delay so CSS transitions can take effect, then remove overlay
            setTimeout(() => removeOverlay(overlay), 120);
            // dispatch event in case other scripts wait for images
            window.dispatchEvent(new Event("loader:imagesReady"));
        });
        // safety: if nothing to preload, reveal immediately
        if (urls.length === 0) {
            document.body.classList.add("page-loaded");
            removeOverlay(overlay);
            window.dispatchEvent(new Event("loader:imagesReady"));
        }
    });
})();
