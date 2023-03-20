let mix = require('laravel-mix');

mix.setPublicPath('./public');
mix.setResourceRoot('./../');

mix
    .sass('resources/styles/growtype-cpt.scss', 'styles');

mix
    .js('resources/scripts/growtype-cpt.js', 'scripts');

mix
    .copyDirectory('resources/plugins', 'public/plugins')
    .copyDirectory('resources/images', 'public/images');

mix
    .sourceMaps()
    .version();
