const webpack = require("webpack");
const path = require("path");
const ExtractTextWebpackPlugin = require("extract-text-webpack-plugin");
const UglifyJSPlugin = require("uglifyjs-webpack-plugin");
const OptimizeCSSAssets = require("optimize-css-assets-webpack-plugin");
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const glob = require('glob');
const globImporter = require('node-sass-glob-importer');

/* Change it according to your development web server */
let PROXY = 'http://127.0.0.1:8090/';

const extractFront = new ExtractTextWebpackPlugin('./dist/app.min.css');
const extractAdmin = new ExtractTextWebpackPlugin('./dist/admin.min.css');
const extractOptions = {
    fallback: 'style-loader',
    use: [
        'css-loader',
        {
            loader: 'sass-loader',
            options: {
                importer: globImporter(),
                query: {
                    includePaths: [path.resolve(__dirname, 'node_modules')]
                },
            }
        },
        'postcss-loader'
    ],
};

let config = {
    entry: {
        admin: "./src/admin/js/app.js",
        app: ["./src/js/app.js"].concat(glob.sync('./blocks/**/*.js'))
    },
    output: {
        path: path.resolve(__dirname, "./"),
        filename: "./dist/[name].min.js"
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                use: [
                    { loader: 'babel-loader' },
                    { loader: 'imports-loader?define=>false'}
                ],
                exclude: /node_modules\/(?!(foundation-sites)\/).*/
            },
            {
                test: /app.scss$/,
                use: extractFront.extract(extractOptions)
            },
            {
                test: /admin.scss$/,
                use: extractAdmin.extract(extractOptions)
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)(\?.*)?$/,
                loader: 'file-loader',
                options: {
                    name: '[name].[hash].[ext]',
                    outputPath: 'dist/fonts/',
                    publicPath: 'fonts/'
                }
            },
            {
                test: /\.(png|jpe?g|gif|svg)$/,
                loader: 'file-loader',
                options: {
                    name: '[name].[hash].[ext]',
                    outputPath: 'dist/images/',
                    publicPath: 'images/'
                }
            }
        ]
    },
    plugins: [
        extractFront,
        extractAdmin
    ],
    externals: [
        'foundation-sites'
    ]
};

config.plugins.push(new CleanWebpackPlugin(['dist'], {
    root: path.resolve('./'),
    verbose: true
}));

module.exports = config;

if (process.env.NODE_ENV === 'production') {
    module.exports.plugins.push(
        new webpack.optimize.UglifyJsPlugin({
            output: {
                comments: false
            }
        }),
        new OptimizeCSSAssets()
    );
}else{
    module.exports.plugins.push(
        new BrowserSyncPlugin({
            host: 'localhost',
            port: 3000,
            proxy: PROXY,
        })
    );
}
