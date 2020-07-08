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
    .js('resources/js/components/generaltaskinput.vue', 'public/js')
    .js('resources/js/components/listcreator.vue', 'public/js')
    .js('resources/js/components/taskinput.vue', 'public/js')
    .js('resources/js/components/tasklist.vue', 'public/js')
    .js('resources/js/components/tasklistselector.vue', 'public/js')
    //.js('resources/js/components/doitapp.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
