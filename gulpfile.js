'use strict';

let gulp         = require('gulp'),
	rename       = require("gulp-rename"),
	notify       = require('gulp-notify'),
	autoprefixer = require('gulp-autoprefixer'),
	sass         = require('gulp-sass');

//css
gulp.task('css', () => {
	return gulp.src('./assets/public/scss/public-styles.scss')
		.pipe(sass( { outputStyle: 'compressed' } ))
		.pipe(autoprefixer({
				browsers: ['last 10 versions'],
				cascade: false
		}))

		.pipe(rename('public-styles.css'))
		.pipe(gulp.dest('./assets/public/assets/css/'))
		.pipe(notify('Compile Sass Done!'));
});

gulp.task('css-admin', () => {
	return gulp.src('./assets/admin/scss/admin-styles.scss')
		.pipe(sass( { outputStyle: 'compressed' } ))
		.pipe(autoprefixer({
				browsers: ['last 10 versions'],
				cascade: false
		}))

		.pipe(rename('admin-styles.css'))
		.pipe(gulp.dest('./assets/admin/css/'))
		.pipe(notify('Compile Sass Done!'));
});

//watch
gulp.task('watch', () => {
	gulp.watch('./assets/public/scss/**', ['css']);
	gulp.watch('./assets/admin/scss/**', ['css-admin']);
});
