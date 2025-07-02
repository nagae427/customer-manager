import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: true,
        port: 5173,
        hmr: {
            host: 'host.docker.internal', 
            protocol: 'ws',
            port: 5173,
        },
        watch: {
            usePolling: true,
        }
    },
    build: { manifest: true }
});