import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

const certPath = path.resolve(process.env.HOME || process.env.USERPROFILE, '.config/herd/config/valet/Certificates');

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        https: fs.existsSync(path.join(certPath, 'Pawsitive_Vibes.test.key')) ? {
            key: fs.readFileSync(path.join(certPath, 'Pawsitive_Vibes.test.key')),
            cert: fs.readFileSync(path.join(certPath, 'Pawsitive_Vibes.test.crt')),
        } : false,
        host: 'Pawsitive_Vibes.test',
        hmr: {
            host: 'Pawsitive_Vibes.test',
        },
    },
});
