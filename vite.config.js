import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    server: {
        host: '0.0.0.0',  // Listen on all network interfaces
        port: 5173,
        hmr: {
            host: '192.168.100.11',  // UBAH DENGAN IP ADDRESS KOMPUTER ANDA
            port: 5173,
        },
        middlewareMode: false,
        cors: {
            origin: '*',
            methods: ['GET', 'HEAD', 'PUT', 'POST', 'DELETE', 'PATCH', 'OPTIONS'],
            allowedHeaders: '*',
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
