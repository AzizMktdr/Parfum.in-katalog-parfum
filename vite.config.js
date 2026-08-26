import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
    build: {
        // Minify & terser untuk JS
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,   // hapus console.log di production
                drop_debugger: true,
            },
        },
        // CSS code-splitting lebih efisien
        cssCodeSplit: true,
        // Chunk warning threshold
        chunkSizeWarningLimit: 500,
        rollupOptions: {
            output: {
                // Asset naming dengan hash untuk cache busting
                assetFileNames: 'assets/[name]-[hash][extname]',
                chunkFileNames: 'assets/[name]-[hash].js',
                entryFileNames: 'assets/[name]-[hash].js',
            },
        },
    },
});
