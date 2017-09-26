var webpack = require( 'webpack' );
var path = require( 'path' );

const config = {
	entry: './assets/src/js/admin-main.js',
	output: {
		path: path.resolve( __dirname, './assets/dist/js' ),
		filename: 'admin-main.js'
	},
	module: {
		rules: [
			{
				test: /\.css$/,
				use: [ 'style-loader', 'css-loader' ]
			},
			{
				test: /\.js$/,
				exclude: /node_modules/,
				loader: 'babel-loader'
			}
		]
	},
	plugins: []
};

switch ( process.env.NODE_ENV ) {
	case 'production':
		config.plugins.push( new webpack.optimize.UglifyJsPlugin() );
		break;

	default:
		config.devtool = 'source-map';
}

module.exports = config;
