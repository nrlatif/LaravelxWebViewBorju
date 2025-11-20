import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    server: {
        host: '0.0.0.0',  // Listen on all network interfaces
        port: 5174,
        hmr: {
            host: '192.168.18.64',  // IP ADDRESS KOMPUTER ANDA
            port: 5174,
        },
        middlewareMode: false,
        cors: {
            origin: '*',
            methods: ['GET', 'HEAD', 'PUT', 'POST', 'DELETE', 'PATCH', 'OPTIONS'],
            allowedHeaders: '*',
        },
    },
    build: {
        // Optimasi build untuk performance
        cssCodeSplit: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    firebase: ['firebase/app', 'firebase/auth', 'firebase/firestore'],
                }
            }
        },
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true, // Hapus console.log di production
            }
        }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
