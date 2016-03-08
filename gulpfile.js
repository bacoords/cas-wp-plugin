var gulp = require('gulp');
var	gutil = require('gulp-util');
var	sass = require('gulp-sass');
var	imagemin = require('gulp-imagemin');
var	autoprefixer = require('gulp-autoprefixer');
var minifycss = require('gulp-minify-css');
var sourcemaps = require('gulp-sourcemaps');
var connect = require('gulp-connect');

gulp.task('default', ['serve', 'watch']);


gulp.task('css', function(){
	return gulp.src('src/scss/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass())
		.pipe(autoprefixer())
		.pipe(minifycss())
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('dist/css'))
		.pipe(connect.reload());
});

gulp.task('serve', function(){
	connect.server({
		livereload:true
	});
});

gulp.task('images', function(){
	return gulp.src('src/img/*')
		.pipe(imagemin())
		.pipe(gulp.dest('dist/img'));
});

gulp.task('watch', function(){
	gulp.watch('src/scss/**/*.scss', ['css']);
	gulp.watch('src/img/*', ['images']);
});