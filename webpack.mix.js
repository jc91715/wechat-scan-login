let mix = require('laravel-mix');
mix
    .js('resources/js/common/bootstrap.js', 'js/bootstrap.js')
    .js('resources/js/front/app.js', 'js/app.js')
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery']
    })
    .sass('resources/sass/app.scss', 'css/')
    .extract(['vue', 'vue-router', 'axios','jquery','lodash']) // 提取依赖库
    .version()
    .setResourceRoot('/build/') // 设置资源目录
    .setPublicPath('./public/build') // 设置 mix-manifest.json 目录
// let mix = require('laravel-mix');
// mix
//     .js('resources/js/app.js', 'js/')
//     .sass('resources/sass/app.scss', 'css/')
