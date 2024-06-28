import { defineConfig } from 'vite';
import vue from "@vitejs/plugin-vue";
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'node_modules/jquery/dist/jquery.min.js'],
            refresh: true,
        }),
        vue(),
        
    ],
});
