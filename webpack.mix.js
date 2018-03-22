let mix = require('laravel-mix');
let exec = require('child_process').exec;
let path = require('path');

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
// .copy('node_modules/sweetalert/dist/sweetalert.min.js', 'public/js/sweetalert.min.js')

mix.sass('resources/assets/sass/app.scss', 'public/css')
.sass('resources/assets/sass/app-rtl.scss', 'public/css')
.sass('resources/assets/sass/custom.scss', 'public/css')
.js('resources/assets/js/app.js', 'public/js')
.js('resources/assets/js/dashboard.js', 'public/js/metro.js')
.js('resources/assets/js/login.js', 'public/js/metro.js')
.then(() => {
    exec('node_modules/rtlcss/bin/rtlcss.js public/css/app-rtl.css ./public/css/app-rtl.css');
})
.version(['public/css/app-rtl.css'])
.webpackConfig({
    resolve: {
        modules: [
            path.resolve(__dirname, 'vendor/laravel/spark-aurelius/resources/assets/js'),
            'node_modules',
            'vue2-datatable-component'
        ],
        alias: {
            'vue$': 'vue/dist/vue.js'
        }
    }
});

if (mix.inProduction())
{
    mix.version();
}
