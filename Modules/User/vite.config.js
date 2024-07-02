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
                const relativePath = 'Modules/User/'+relative(__dirname, filePath);
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

const assetsDir = join(__dirname, 'resources/assets');
export const paths = getFilePaths(assetsDir);

//export const paths = [
//    'Modules/User/resources/assets/sass/app.scss',
//    'Modules/User/resources/assets/js/app.js',
//];