import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});

// import { defineConfig } from 'vite';
// import vue from '@vitejs/plugin-vue';
// import path from 'path';
//
// export default defineConfig({
//     plugins: [vue()],
//     resolve: {
//         alias: {
//             '@': path.resolve(__dirname, 'resources/js'),
//         },
//     },
//     server: {
//         host: 'localhost',
//         port: 3000,
//     },
// });
//
//
