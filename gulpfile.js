
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.sass([
        'bootstrap.scss',
    ], 'public/assets/css/bootstrap.css');
});

elixir(function(mix) {
    mix
        .styles(['font-awesome.css'], 'public/assets/css/font-awesome.css')
        .styles(['fonts.css'], 'public/assets/css/fonts.css')
        .styles(['app.css'], 'public/assets/css/app.css');
});

elixir(function(mix) {
    mix
        .scripts(['jquery.js'], 'public/assets/js/jquery.js')
        .scripts(['app.js'], 'public/assets/js/app.js');
});

elixir(function(mix) {
    mix
        .copy('node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js', 'public/assets/js/bootstrap.js')
        .copy('resources/assets/fonts/', 'public/build/assets/fonts/')
        .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/', 'public/build/assets/fonts/');
});

// 版本号码缓存必须放在编译之后
elixir(function(mix) {
    mix.version(['assets/css/', 'assets/js/']);
});
