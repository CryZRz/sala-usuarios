import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import {glob} from "glob";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/scss/authLayout.scss',
                'resources/scss/utils/colors.scss',
                'resources/scss/utils/sizes.scss',
                'resources/js/app.js',
                ...glob.sync("resources/js/**/*.js"),
            ],
            refresh: true,
        }),
    ],
});
