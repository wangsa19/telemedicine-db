import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/filament/admin/theme.css'],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
                'app/Filament/**/*.php',
                'resources/views/filament/**/*.blade.php',
                'vendor/filament/**/*.blade.php',
                'resources/css/filament/admin/theme.css'
            ],
        }),
    ],
});
