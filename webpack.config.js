const webpack = require('webpack');
const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const inProduction = (process.env.NODE_ENV === 'production');

// Sass plugin.
// const extractSass = new ExtractTextPlugin('css/[name].css');
const extractSass = new ExtractTextPlugin((inProduction ? 'css/[name].min.css' : 'css/[name].css'));
const extractSassConfig = {
	use: [{
		loader: 'css-loader',
		options: {
			sourceMap: true
		}
	}, {
		loader: 'sass-loader',
		options: {
			sourceMap: true,
			outputStyle: 'production' === process.env.NODE_ENV ? 'compressed' : 'nested',
		}
	}]
};

// Webpack config.
const config = {
	entry: {
		'admin-main': './assets/src/js/admin-main.js'
	},
	output: {
		path: path.resolve(__dirname, './assets/dist'),
		filename: (inProduction ? 'js/[name].min.js' : 'js/[name].js')
	},
	devtool: "source-map",
	module: {
		rules: [
			{
				test: /\.scss$/,
				use: extractSass.extract(extractSassConfig)
			},
			{
				test: /\.(png|jpg|gif|svg|eot|ttf|woff|woff2)$/,
				loader: 'url-loader',
				options: {
					limit: 10000
				}
			},
			{
				test: /\.js$/,
				exclude: /node_modules/,
				loader: 'babel-loader'
			}
		]
	},
	plugins: [
		extractSass
	]
};

switch (process.env.NODE_ENV) {
	case 'production':
		config.plugins.push(new webpack.optimize.UglifyJsPlugin()); // Uglify JS.
		config.plugins.push(new webpack.LoaderOptionsPlugin({ minimize: true })); // Minify CSS.
		break;
}

module.exports = config;
