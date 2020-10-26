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

mix
    .js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .js('resources/assets/js/app.js', 'public/assets/js')
    .js('resources/assets/js/fontawesome.js', 'public/assets/js')
    .sass('resources/assets/sass/app.scss', 'public/assets/css')
    .sass('resources/assets/sass/emails.scss', '../resources/views/vendor/mail/html/themes/default.css')
    .copy('resources/assets/fonts', 'public/assets/fonts')
    .copy('resources/assets/fonts', 'storage/fonts')
    .copy('resources/assets/images', 'public/assets/images')

    .sass('resources/assets/sass/combination.scss', 'public/assets/css/resumes')
    .sass('resources/assets/sass/functional.scss', 'public/assets/css/resumes')
    .sass('resources/assets/sass/gold-standard.scss', 'public/assets/css/resumes')
    .sass('resources/assets/sass/recruiter.scss', 'public/assets/css/resumes')
    .sass('resources/assets/sass/sidebar.scss', 'public/assets/css/resumes')

if (!mix.inProduction() && !process.env.SKIP_BROWSER_SYNC) {
    mix.browserSync({
        proxy: 'resume.cheekyscientist.test/',
        files: [
            // files to watch and reload (or hot reload if .css) when changed
            '**/*.php',
            'resources/**/*.js',
            'resources/**/*.vue',
            'resources/**/emails.scss',
            'public/**/*.css' // Only watch if final compiled css changes, this allows the css to be live injected without a page reload
        ]
    })
    .sourceMaps()
    .webpackConfig({ devtool: "inline-source-map" });
}

if (mix.inProduction()) {
   mix.version();
}
