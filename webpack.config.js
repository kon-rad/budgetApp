var path = require('path');
var webpack = require('webpack');
var node_modules_dir = path.join(__dirname, 'node_modules');
var ExtractTextPlugin = require('extract-text-webpack-plugin');

var config = {
    entry: [
        'webpack-dev-server/client?http://127.0.0.1:3000',
        './app/Resources/js/app.js',
        './app/Resources/scss/style.scss'
    ],
    output: {
        path: path.join(__dirname, 'web/dist'),
        filename: 'bundle.js',
        publicPath: 'http://127.0.0.1:3000/static/'
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin(),
        new webpack.NoErrorsPlugin(),
        new ExtractTextPlugin({ filename: 'style.css', allChunks: true }),
    ],
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                include: path.join(__dirname, 'app/Resources/js'),
                exclude: node_modules_dir,
                use: ['babel-loader?presets[]=es2015&presets[]=react']
             
            },
            {
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    fallback: "style-loader",
                    use: "css-loader!sass-loader",
                  })
            },
            {
                test: /\.jpe?g$|\.gif$|\.png$|\.svg$|\.woff$|\.woff2?$|\.ttf$|\.eot$|\.svg$/,
                use: "file-loader?name=[name].[ext]"
            }
        ]
    }
};
module.exports = config;