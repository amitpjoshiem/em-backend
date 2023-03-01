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

mix.js('resources/docs/swagger/js/swagger-ui.js', 'public/documentation/js')
    .postCss('resources/docs/swagger/css/swagger-ui.css', 'public/documentation/css');

mix.js('resources/assets/js/admin.js', 'public/assets/js/')
    .sass('resources/assets/sass/admin.scss', 'public/assets/css/').version();

mix.copyDirectory('resources/assets/img', 'public/assets/img');

