var gulp = require( 'gulp' );
var sass = require( 'gulp-sass' );
var browsersync = require( 'browser-sync' ).create();
var concat = require( 'gulp-concat' );
var uglify = require( 'gulp-uglify' );
var postcss = require( 'gulp-postcss' );
var sourcemaps = require( 'gulp-sourcemaps' );
var autoprefixer = require( 'autoprefixer' );
var cssnano = require( 'cssnano' );
var imagemin = require( 'gulp-imagemin' );

gulp.task( 'styles', function () {
	var plugins = [
		autoprefixer( {
			browsers: [ 'last 2 versions' ],
		} ),
		cssnano(),
	];

	return gulp.src( 'assets/scss/**/*.scss' )
	           .pipe( sass() )
	           .pipe( sourcemaps.init() )
	           .pipe( postcss( plugins ) )
	           .pipe( sourcemaps.write( '.' ) )
	           .pipe( gulp.dest( 'dist/css' ) )
	           .pipe( browsersync.stream() );
} );

gulp.task( 'scripts', function () {
	var scripts = [
//		'assets/js/script1.js',
	];

	return gulp.src( scripts )
	           .pipe( concat( 'main.js' ) )
	           .pipe( uglify() )
	           .pipe( gulp.dest( 'dist/js' ) )
	           .pipe( browsersync.reload( { stream: true } ) );
} );

gulp.task( 'images', function () {
	return gulp.src( 'assets/images/**/*.+(png|jpg|jpeg|gif|svg)' )
	           .pipe( imagemin() )
	           .pipe( gulp.dest( 'dist/images' ) )
	           .pipe( browsersync.reload( { stream: true } ) );
} );

gulp.task( 'browsersync', function () {
	browsersync.init( {
		proxy: 'wpbr-development.dev',
	} )
} );

gulp.task( 'watch', [ 'browsersync', 'styles', 'scripts' ], function () {
	gulp.watch( '**/*.php', browsersync.reload );
	gulp.watch( 'assets/scss/**/*.scss', [ 'styles' ] );
	gulp.watch( 'assets/js/**/*.js', [ 'scripts' ] );
	gulp.watch( 'assets/images/**/*.+(png|jpg|jpeg|gif|svg)', [ 'images' ] );
} );

gulp.task( 'default', [ 'styles', 'scripts', 'images' ] );
