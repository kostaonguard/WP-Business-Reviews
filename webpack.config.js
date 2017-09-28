const webpack = require('webpack');
const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const inProduction = (process.env.NODE_ENV === 'production');
const DashboardPlugin = require('webpack-dashboard/plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const SuppressChunksPlugin = require('suppress-chunks-webpack-plugin').default;
const CleanWebpackPlugin = require('clean-webpack-plugin');

// Sass plugin.
// const extractSass = new ExtractTextPlugin('css/[name].css');
const extractSass = new ExtractTextPlugin((inProduction ? '[name].min.css' : '[name].css'));
const extractSassConfig = {
	use: [{
		loader: 'css-loader',
		options: {
			sourceMap: true,
			url: false
		}
	}, {
		loader: 'sass-loader',
		options: {
			sourceMap: true,
			outputStyle: 'production' === process.env.NODE_ENV ? 'compressed' : 'nested'
		}
	}]
};

const entry = {
	'js/admin-main': './assets/src/js/admin-main.js',
	'css/admin-main': './assets/src/css/admin-main.scss'
}

// Webpack config.
const config = {
	entry: entry,
	output: {
		path: path.resolve(__dirname, './assets/dist/'),
		filename: (inProduction ? '[name].min.js' : '[name].js')
	},
	devtool: 'source-map',
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				loader: 'babel-loader'
			},
			{
				test: /\.scss$/,
				use: extractSass.extract(extractSassConfig)
			}
		]
	},
	plugins: [
		extractSass,
		new SuppressChunksPlugin(
			Object.keys(entry).filter(name => (name.indexOf('js') === -1) ),
			{filter: /\.js(\.map)?$/}
		),
		new CleanWebpackPlugin(['assets/dist']),
		new CopyWebpackPlugin([{
			from: './assets/src/images/',
			to: 'images'
		}]),
		new ImageminPlugin({ test: /\.(jpe?g|png|gif|svg)$/i }),
		new BrowserSyncPlugin({
			// Browse to http://localhost:3000/ during development.
			files: [
				'**/*.php',
			],
			host: 'localhost',
			port: 3000,
			proxy: 'wpbr-development.dev',
		}),
		new DashboardPlugin()
	]
};

switch (process.env.NODE_ENV) {
	case 'production':
		config.plugins.push(new webpack.optimize.UglifyJsPlugin()); // Uglify JS.
		config.plugins.push(new webpack.LoaderOptionsPlugin({ minimize: true })); // Minify CSS.
		break;
}

module.exports = config;
