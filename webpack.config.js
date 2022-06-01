const Encore = require('@symfony/webpack-encore');
const ImageMinPlugin = require('imagemin-webpack');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const path = require('path');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })

    // enables @babel/preset-env polyfills
    // .configureBabelPresetEnv((config) => {
    //     config.useBuiltIns = 'usage';
    //     config.corejs = 3;
    // })

    .configureImageRule({ enabled: false })
    // .disableImagesLoader()

    // enables Sass/SCSS support
    .enableSassLoader()

    .enablePostCssLoader((options) => {
        options.postcssOptions = {
            // the directory where the postcss.config.js file is stored
            path: './postcss.config.js',
        };
    })

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    .enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    .enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
    .addStyleEntry('base', './assets/scss/main.scss')
    // .copyFiles({from: "./assets/icons", to: "icons/[name].[hash:8].[ext]"})
    // .copyFiles({from: "./assets/images", to: "images/[name].[hash:8].[ext]"})

    .addRule({
        test: /\.(png|jpg|jpeg|gif|ico|svg|webp)$/,
        loader: 'file-loader',
        exclude: [path.resolve(__dirname, 'assets/icons')],
        options: {
            name: 'images/[name].[hash:8].[ext]',
        },
    })
    .addRule({
        test: /\.svg$/,
        include: [path.resolve(__dirname, 'assets/icons')],
        loader: 'svg-sprite-loader',
        options: {
            extract: true,
            spriteFilename: (svgPath) => `/sprite${svgPath.substr(-4)}`,
        },
    })
    .addPlugin(new SpriteLoaderPlugin())
    .addPlugin(
        new ImageMinPlugin({
            bail: false,
            cache: true,
            imageminOptions: {
                plugins: [
                    ['gifsicle', { interlaced: true }],
                    ['jpegtran', { progressive: true }],
                    ['optipng', { optimizationLevel: 5 }],
                    ['svgo'],
                ],
            },
        }),
    );

const config = Encore.getWebpackConfig();

config.watchOptions = {
    poll: true,
};

config.resolve.alias = {
    Env: path.resolve(__dirname, 'assets/js/env.js'),
    App: path.resolve(__dirname, 'assets/js/react/App/'),
    Assets: path.resolve(__dirname, 'assets/js/assets.js'),
    Error: path.resolve(__dirname, 'assets/js/react/Error/'),
    Hoc: path.resolve(__dirname, 'assets/js/react/Hoc/'),
    Services: path.resolve(__dirname, 'assets/js/react/Services/'),
    Templates: path.resolve(__dirname, 'assets/js/react/Templates/'),
    Widgets: path.resolve(__dirname, 'assets/js/react/Widgets/'),
    InfoManual: path.resolve(__dirname, 'assets/js/react/InfoManual/'),
};
module.exports = config;
