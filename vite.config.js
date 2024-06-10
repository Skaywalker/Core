import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import collectModuleAssetsPaths from "./vite-module-loader.js";
import path, {resolve} from "path";

/*import glob from 'glob';
import path from 'path';*/

const host = 'core.test';
console.log(path.resolve(__dirname + '/Modules'),'modules path')
async function getConfig() {
    const paths = [
        'resources/css/app.css',
        'resources/js/app.js',
    ];
    const allPaths = await collectModuleAssetsPaths(paths, 'Modules');
    console.log(allPaths);
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
                ssr: 'resources/js/ssr.js',
                refresh: true,
            })
        ],
        resolve:{
            alias:{
                '@modules' : path.resolve('Modules')

            },
        }
    });
}
export default getConfig();

/*
export default defineConfig({
    server:{
        host,
        hmr: { host }
/!*        https: {
            key: fs.readFileSync(`/path/to/${host}.key`),
            cert: fs.readFileSync(`/path/to/${host}.crt`),
        },*!/
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
            input: ['resources/css/app.css', 'resources/js/app.ts',],
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
    ],
});
*/