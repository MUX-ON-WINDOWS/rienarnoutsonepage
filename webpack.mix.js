const mix = require('laravel-mix');

require('mix-tailwindcss');

mix.browserSync({
    proxy: 'http://localhost:8000/'
});

mix.js('src/app.js', 'dist').setPublicPath('dist');
