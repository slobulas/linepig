const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.styles([
        'bootstrap.min.css',
        'styles.css'
    ]);

    mix.scripts([
        'jquery-3.1.1.min.js',
        'bootstrap.min.js'
    ]);

    mix.copy('resources/assets/fonts', 'public/fonts');

    mix.version('css/all.css');
    mix.version('js/all.js');
});
