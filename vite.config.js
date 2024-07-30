import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import viteSass from 'vite-plugin-sass';


// @ts-ignore
import path, {resolve} from "path";

import collectModuleAssetsPaths from "./vite-module-loader.js";

/*import glob from 'glob';
import path from 'path';*/

const host = 'core.test';
async function getConfig() {
    const paths = [];
    const allPaths = await collectModuleAssetsPaths(paths, 'Modules');

    return defineConfig({
        server:{
            host,
            hmr: { host }

        },

        plugins: [
            laravel({
                input: allPaths,
                // ssr: 'resources/js/ssr.js',
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
        build:{
            outDir: 'public/build',
            emptyOutDir: true,
            rollupOptions:{
                input: allPaths,
            },
            sourcemap: true,
        },

        resolve:{
            alias:{
                '@modules' : path.resolve('Modules'),
                // @ts-ignore

                '@AdminModule': path.resolve(__dirname, 'Modules/Admin/resources/assets/js'),
                // @ts-ignore

                '@WebsiteModule':path.resolve(__dirname, 'Modules/Admin/resources/assets/js'),
                'ziggy-js': path.resolve('vendor/tightenco/ziggy'),

            },
        },
    });
}
export default getConfig();