import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 12001,
        strictPort: true,
        hmr: {
            host: 'work-2-ekfeiisdninjbbee.prod-runtime.all-hands.dev',
        },
        watch: {
            usePolling: true,
        },
    },
});
