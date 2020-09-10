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
    .js('resources/js/auth/register.js', 'public/js/auth')
    .js('resources/js/auth/login.js', 'public/js/auth')
    .js('resources/js/forum/forum.js', 'public/js/forum')
    .js('resources/js/forum/create.js', 'public/js/forum')
    .js('resources/js/search/index.js', 'public/js/search')
    .js('resources/js/home/index.js', 'public/js/home')
    .js('resources/js/home/profile.js', 'public/js/home')
    .js('resources/js/view_profile/index.js', 'public/js/view_profile')
    .sass('resources/sass/main.scss', 'public/css');

