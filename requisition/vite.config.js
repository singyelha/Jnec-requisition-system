// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; // <-- Import the Vue plugin

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', // Your original inputs
                'resources/js/app.js',     // Assumes app.js initializes Vue
            ],
            refresh: true,
        }),
        vue({ // <-- Add the Vue plugin configuration
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: { // <-- Add the resolve alias for Vue
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js', // Use the bundler-aware build of Vue
        },
    },
});