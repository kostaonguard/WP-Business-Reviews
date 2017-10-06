const webpack = require( 'webpack' );
const path = require( 'path' );
const ExtractTextPlugin = require( 'extract-text-webpack-plugin' );
const inProduction = ( 'production' === process.env.NODE_ENV );
const BrowserSyncPlugin = require( 'browser-sync-webpack-plugin' );
const ImageminPlugin = require( 'imagemin-webpack-plugin' ).default;
const CleanWebpackPlugin = require( 'clean-webpack-plugin' );

// Webpack config.
const config = {
	entry: {
		'admin-main': './assets/src/js/admin-main.js'
	},
	output: {
		path: path.resolve( __dirname, './assets/dist/' ),
		filename: ( inProduction ? 'js/[name].min.js' : 'js/[name].js' )
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
				use: ExtractTextPlugin.extract({
					use: [ {
						loader: 'css-loader',
						options: {
							sourceMap: true
						}
					}, {
						loader: 'postcss-loader',
						options: {
							sourceMap: true
						}
					}, {
						loader: 'sass-loader',
						options: {
							sourceMap: true,
							outputStyle: 'production' === process.env.NODE_ENV ? 'compressed' : 'nested'
						}
					} ]
				})
			}, {
				test: /\.(png|jpg|gif)$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							name: 'images/[name].[ext]',
							publicPath: '../'
						}
					}
				]
			}
		]
	},
	plugins: [
		new ExtractTextPlugin( ( inProduction ? 'css/[name].min.css' : 'css/[name].css' ) ),
		new CleanWebpackPlugin([ 'assets/dist' ]),
		new ImageminPlugin({ test: /\.(jpe?g|png|gif|svg)$/i }),
		new BrowserSyncPlugin({
			files: [
				'**/*.php'
			],
			host: 'localhost',
			port: 3000,
			proxy: 'wpbr-development.dev'
		})
	]
};

if ( inProduction ) {
	config.plugins.push( new webpack.optimize.UglifyJsPlugin({ sourceMap: true }) ); // Uglify JS.
	config.plugins.push( new webpack.LoaderOptionsPlugin({ minimize: true }) ); // Minify CSS.
}

module.exports = config;
