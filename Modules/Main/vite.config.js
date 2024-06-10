/*import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-main',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-main',
            input: [
                __dirname + '/resources/assets/sass/app.scss',
                __dirname + '/resources/assets/js/app.js'
            ],
            refresh: true,
        }),
    ],
});*/






import { readdirSync, statSync } from 'fs';
import { join,relative,dirname } from 'path';
import { fileURLToPath } from 'url';

function getFilePaths(dir) {
    const filePaths = [];

    function walkDirectory(currentPath) {
        const files = readdirSync(currentPath);
        for (const file of files) {
            const filePath = join(currentPath, file);
            const stats = statSync(filePath);
            if (stats.isFile() && !file.startsWith('.')) {
                const relativePath = 'Modules/Main/'+relative(__dirname, filePath);
                filePaths.push(relativePath);
            } else if (stats.isDirectory()) {
                walkDirectory(filePath);
            }
        }
    }

    walkDirectory(dir);
    return filePaths;
}

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
// Példa a használatra
const assetsDir = join(__dirname, 'resources/assets');
export const paths = getFilePaths(assetsDir);



//export const paths = [
//    'Modules/Main/resources/assets/sass/app.scss',
//    'Modules/Main/resources/assets/js/app.js',
//];