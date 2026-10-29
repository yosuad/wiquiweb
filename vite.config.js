import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // ── CSS ────────────────────────────────────────
                // General
                'resources/css/app.css',

                // Sitio: servicios (orden del menú)
                'resources/css/site/services/emails.css',
                'resources/css/site/services/design.css',
                'resources/css/site/services/consulting.css',
                'resources/css/site/services/landing.css',

                // Sitio: portafolio
                'resources/css/site/portfolio/yosuad.css',

                // Formulario de leads (Meta)
                'resources/css/leads/form.css',

                // ── JS ─────────────────────────────────────────
                // General
                'resources/js/app.js',

                // Formulario de leads (Meta)
                'resources/js/leads/form.js',

                // Admin
                'resources/js/admin/blog/form.js',
                'resources/js/admin/blog/categories/index.js',
                'resources/js/admin/prospects/edit.js',
            ],
            refresh: true,
        }),
    ],
});