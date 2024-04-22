import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/scss/authLayout.scss',
                'resources/scss/utils/colors.scss',
                'resources/scss/utils/sizes.scss',
                'resources/js/app.js',
                'resources/js/session/show.js',
                'resources/js/session/create.js',
                'resources/js/session/counterManager.js',
                'resources/js/session/navbarActions.js',
                'resources/js/computer/create.js',
                'resources/js/computer/edit.js'
            ],
            refresh: true,
        }),
    ],
});
