let mix = require('laravel-mix');

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

mix.js([
      'assets/js/app.js',
      'public/js/RGraph.common.core.js',
      'public/js/RGraph.line.js',
      'public/js/RGraph.bar.js',
      'bower_components/validator-js/validator.js',
   ], 'public/js')
   // .sass(
   //    'assets/sass/app.scss'
   // , 'public/css')
   .styles([
      'public/css/style.css',
   ], 'public/css/all.css')

