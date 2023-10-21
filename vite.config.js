import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/bundle/dashboard.bundle.js',
                'resources/js/bundle/detail.bundle.js',
                'resources/js/bundle/show-file.bundle.js',
            ],
            refresh: true,
        }),
    ],
});
