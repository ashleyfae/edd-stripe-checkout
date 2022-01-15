let mix = require('laravel-mix');

mix
    .sass('assets/src/sass/index.scss', 'assets/dist/css')
    .js('assets/src/js/index.js', 'assets/dist/js/index.js');
