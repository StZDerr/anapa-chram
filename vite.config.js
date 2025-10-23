import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/js/app.js",
                "resources/css/app.css",
                "resources/css/welcome.css",
                "resources/css/zapiski.css",
                "resources/css/treby.css",
                "resources/css/temple.css",
                "resources/css/news.css",
                "resources/css/news-read.css",
                "resources/css/gallery.css",
                "resources/css/activity.css",
                "resources/css/about.css",
                "resources/css/footer.css",
                "resources/css/navbar.css",
                "resources/css/calendar.css",
                "resources/css/contact.css",
                "resources/css/donation-modal.css",
                "resources/css/prayer-modal.css",
                "resources/css/park.css",
                "resources/js/app.js",
                "resources/js/welcome.js",
                "resources/js/zapiski.js",
                "resources/js/treby.js",
                "resources/js/temple.js",
                "resources/js/news-read.js",
                "resources/js/gallery.js",
                "resources/js/calendar.js",
                "resources/js/prayer-modal.js",
                "resources/js/park.js",
            ],
            refresh: true,
        }),
    ],
});
