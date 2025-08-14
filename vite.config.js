import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input:
            ['resources/css/app.css',
            'resources/js/app.js',
            'resources/css/dashboard/admin.css',
            'resources/css/dashboard/responsive.css',
            'resources/js/dashboard/app.js',
            'resources/css/web/web.css',
            'resources/css/web/responsive.css',
        ],
            refresh: true,
        }),
    ],
});
