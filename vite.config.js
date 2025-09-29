import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css'], // Укажите ваши точки входа
            output: 'public/build/assets', // Укажите директорию для выходных файлов
            refresh: true, // Включите автоматическое обновление при разработке
        }),
    ],
    build: {
        outDir: 'public/build', // Директория для выходных файлов
        emptyOutDir: true, // Очистить выходную директорию перед сборкой
    },
});

