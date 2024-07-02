import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
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
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
            laravel({
                input: allPaths,
                // ssr: 'resources/js/ssr.js',
                refresh: true,
            }),

        ],
        build:{
            outDir: 'public/build',
            rollupOptions:{
                input: allPaths,
            },
        },
        resolve:{
            alias:{
                '@modules' : path.resolve('Modules'),
                '@AdminModule': path.resolve(__dirname, 'Modules/Admin/resources/assets/js'),
                '@WebsiteModule':path.resolve(__dirname, 'Modules/Admin/resources/assets/js'),
            },
        },
    });
}
export default getConfig();