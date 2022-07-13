const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/admin_app.js', 'public/js/admin_app.js')
    .js([
        'resources/js/userapp.js',
        ], 'public/js/userapp.js')
    //.copyDirectory('resources/images', 'public/images')
    .sass('resources/sass/app_admin.scss', 'public/css/admin_app.css')
    .sass('resources/sass/style.scss', 'public/css/')
    .sourceMaps();
