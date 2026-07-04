import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/leads/form.css',
                'resources/js/leads/form.js',
                'resources/css/pages/services/emails.css',
                'resources/css/pages/services/design.css',
                'resources/css/pages/services/consulting.css',
                'resources/css/pages/services/landing.css',
                'resources/css/pages/portfolio/yosuad.css',
            ],
            refresh: true,
        }),
    ],
});