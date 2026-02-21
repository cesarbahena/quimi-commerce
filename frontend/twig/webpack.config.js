const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const ESLintPlugin = require('eslint-webpack-plugin');

const isDev = process.env.NODE_ENV === 'development';

module.exports = {
    entry: './assets/js/app.js',
    output: {
        path: path.resolve(__dirname, 'public/build'),
        filename: isDev ? '[name].js' : '[name].[contenthash].js',
        clean: true,
        publicPath: '/build/',
    },
    devtool: isDev ? 'eval-source-map' : 'source-map',
    devServer: {
        static: {
            directory: path.join(__dirname, 'public'),
        },
        port: 3000,
        hot: true,
        historyApiFallback: true,
        proxy: [
            {
                context: ['/api', '/_wdt', '/_profiler'],
                target: 'http://localhost:8000',
            },
        ],
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
            },
            {
                test: /\.scss$/,
                use: [
                    isDev ? 'style-loader' : MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader',
                ],
            },
            {
                test: /\.css$/,
                use: [
                    isDev ? 'style-loader' : MiniCssExtractPlugin.loader,
                    'css-loader',
                ],
            },
            {
                test: /\.(png|svg|jpg|jpeg|gif|webp)$/i,
                type: 'asset/resource',
                generator: {
                    filename: 'images/[name].[hash][ext]',
                },
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/i,
                type: 'asset/resource',
                generator: {
                    filename: 'fonts/[name].[hash][ext]',
                },
            },
        ],
    },
    plugins: [
        new HtmlWebpackPlugin({
            template: './templates/base/index.html.twig',
            filename: 'index.html',
        }),
        new MiniCssExtractPlugin({
            filename: isDev ? '[name].css' : '[name].[contenthash].css',
        }),
        new ESLintPlugin({
            extensions: ['js'],
            context: path.resolve(__dirname, 'assets/js'),
            overrideConfigFile: path.resolve(__dirname, '.eslintrc.js'),
            failOnError: !isDev,
        }),
    ],
    optimization: {
        minimize: !isDev,
        minimizer: [
            new TerserPlugin({
                terserOptions: {
                    compress: {
                        drop_console: !isDev,
                    },
                },
            }),
        ],
        splitChunks: {
            chunks: 'all',
            cacheGroups: {
                vendor: {
                    test: /[\\/]node_modules[\\/]/,
                    name: 'vendors',
                    chunks: 'all',
                },
            },
        },
    },
    resolve: {
        extensions: ['.js'],
        alias: {
            '@': path.resolve(__dirname, 'assets/js'),
        },
    },
};
