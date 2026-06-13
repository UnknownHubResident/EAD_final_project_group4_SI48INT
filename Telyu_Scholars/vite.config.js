import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [], // Left empty because styles are imported via live CDN script tags
            refresh: true,
        }),
    ],
});