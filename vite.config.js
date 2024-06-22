import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path, {resolve} from "path";
// @ts-ignore
import collectModuleAssetsPaths from "./vite-module-loader.js";

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
                '@modules' : path.resolve('Modules'),
                '@AdminModule': resolve(__dirname, 'Modules/Admin/resources/assets/js'),
                '@WebsiteModule': resolve(__dirname, 'Modules/Admin/resources/assets/js'),
            },
        }
    });
}
export default getConfig();