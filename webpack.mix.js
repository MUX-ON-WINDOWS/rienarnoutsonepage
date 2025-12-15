const mix = require('laravel-mix');

require('mix-tailwindcss');

// Output everything to dist/
mix.setPublicPath('dist');

// Optional live reload proxy (can stay if you use it)
mix.browserSync({
    proxy: 'http://localhost:8000/'
});

// Bundle the main front-end script
mix.js('script.js', 'script.js');

// Copy additional JS
mix.copy('mobile.js', 'dist/mobile.js');

// Copy the static HTML entry
mix.copy('index.html', 'dist');

// Copy the main CSS
mix.copy('style.css', 'dist/style.css');

// Copy asset folders
mix.copyDirectory('keramiek', 'dist/keramiek');
mix.copyDirectory('brons', 'dist/brons');
mix.copyDirectory('logo', 'dist/logo');
mix.copyDirectory('img', 'dist/img');
