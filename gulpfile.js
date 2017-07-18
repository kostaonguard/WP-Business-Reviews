var gulp = require( 'gulp' );
var sass = require( 'gulp-sass' );
var browsersync = require( 'browser-sync' ).create();
var concat = require( 'gulp-concat' );
var uglify = require( 'gulp-uglify' );
var postcss = require( 'gulp-postcss' );
var sourcemaps = require( 'gulp-sourcemaps' );
var autoprefixer = require('autoprefixer');
var cssnano = require('cssnano');

gulp.task( 'styles', function () {
	var plugins = [
		autoprefixer(),
		cssnano(),
	];

	return gulp.src( './assets/scss/**/*.scss' )
	    .pipe( sass() )
	    .pipe( sourcemaps.init() )
	    .pipe( postcss( plugins ) )
	    .pipe( sourcemaps.write( '.' ) )
	    .pipe( gulp.dest( './assets/css' ) )
	    .pipe( browsersync.reload( {
		    stream: true,
	    } ) );
} );

gulp.task( 'scripts', function () {
	var scripts = [
		'./assets/js/script1.js',
		'./assets/js/script2.js',
	];

	return gulp.src( scripts )
	           .pipe( concat( 'main.js' ) )
	           .pipe( uglify() )
	           .pipe( gulp.dest( './assets/js/' ) );
} );

gulp.task( 'watch', [ 'browsersync', 'styles' ], function () {
	gulp.watch( './assets/css/src/**/*.scss', [ 'styles' ] );
	gulp.watch( './assets/js/**/*.js', browsersync.reload );
} );

gulp.task( 'browsersync', function () {
	browsersync.init( {
		proxy: 'wpbr-development.dev',
	} )
} );

gulp.task( 'default', [ 'styles', 'scripts' ] );
