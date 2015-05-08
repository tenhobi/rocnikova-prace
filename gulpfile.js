var gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    rename = require('gulp-rename');

// Source and build path.
var source = './src/';

// Input paths.
var input = {
    sass: source + 'sass/**/*.scss'
};

// Output paths.
var output = {
    sass: source + 'css/'
};

// Compile Sass, autoprefix properties, generate CSS.
gulp.task('sass', function () {
    return gulp.src(input.sass)
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(autoprefixer('> 1%'))
        .pipe(rename('style.css'))
        .pipe(gulp.dest(output.sass));
});

// Watch ['Sass'] change in files and run it at begin.
gulp.task('watch:sass', ['sass'], function () {
    gulp.watch(input.sass, ['sass']);
});

// On default call watch.
gulp.task('default', ['sass']);
