
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
var gulp = require('gulp'),
    del = require('del');
    
// 关闭默认源地图
elixir.config.sourcemaps = false;

// 清理旧文件 
gulp.task('clean', function(cb){
    del(['public/assets','public/build'], cb); 
});

elixir(function(mix) {
    mix.task('clean');
});

// 编辑scss文件
elixir(function(mix) {
    mix
    .sass(['bootstrap.scss',], 'public/assets/css/bootstrap.css') 
    .sass(['plugins.scss',], 'public/assets/css/plugins.css');
});

// 编译Less文件
elixir(function(mix) {
    mix.less(['app.less'], 'public/assets/css/app.css');
});

elixir(function(mix) {
    mix.styles(['fineuploader.css'], 'public/assets/css/fineuploader.css');
});

// 将编译Javascript文件
elixir(function(mix) {
    mix
        .scripts(['jquery.js'], 'public/assets/js/jquery.js')
        .scripts(['base.js'], 'public/assets/js/base.js')
        .scripts(['formValidation/*.js'], 'public/assets/js/formValidation.js')
        .scripts(['mustache.js'], 'public/assets/js/mustache.js')
        .scripts(['plugins/*.js'], 'public/assets/js/plugins.js')
        .scripts(['fine-uploader.js'], 'public/assets/js/fine-uploader.js')
        .scripts(['bootstrap.js'], 'public/assets/js/bootstrap.js')
});

elixir(function(mix) {
    mix
        //.copy('resources/assets/fonts/', 'public/build/assets/fonts/')
        .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/', 'public/build/assets/fonts/bootstrap/');
        
    mix.copy('resources/assets/Lodop/', 'public/assets/Lodop/');
});

// 版本号码缓存必须放在编译之后
elixir(function(mix) {
    mix.version(['assets/css/', 'assets/js/']);
});
