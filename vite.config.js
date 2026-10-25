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
                'resources/css/site/services/emails.css',
                'resources/css/site/services/design.css',
                'resources/css/site/services/consulting.css',
                'resources/css/site/services/landing.css',
                'resources/css/site/portfolio/yosuad.css',
            ],
            refresh: true,
        }),
    ],
});