var elixir = require('laravel-elixir');

var paths = {
    'bootstrap': './node_modules/bootstrap/',
    'fontawesome': './node_modules/font-awesome/',
    'roboto': './node_modules/roboto-fontface/'
};

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss', './resources/assets/css/sass.css');
    mix.less('app.less', './resources/assets/css/less.css');
    mix.styles(['*.css'], 'public/css/app.css');
    mix.copy(paths.roboto + 'fonts', 'public/build/fonts');
    mix.copy(paths.bootstrap + 'fonts', 'public/build/fonts');
    mix.copy(paths.fontawesome + 'fonts', 'public/build/fonts');
    mix.browserify('app.js');
    mix.version(['public/css/app.css', 'public/js/app.js']);
});
