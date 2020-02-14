var Encore = require('@symfony/webpack-encore');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/js/app.js')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableVueLoader()
    //.addPlugin(new VuetifyLoaderPlugin())
    .enableSassLoader(options => {
        options.implementation = require('sass');
        options.fiber = require('fibers');
    })
;

module.exports = Encore.getWebpackConfig();