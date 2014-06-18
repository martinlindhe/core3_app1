'use strict';

var gulp = require('gulp');
var clean = require('gulp-clean');
var notify = require('gulp-notify');

var sass = require('gulp-sass');
var minifycss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var jshint = require('gulp-jshint');
var htmlhint = require("gulp-htmlhint");


// default task
gulp.task('default', ['clean'], function() {
    gulp.start('sass', 'jsmin');
});


// TODO rip out existing scss compiler from core3
gulp.task('sass', function() {
    return gulp.src('./scss/*.scss')
        .pipe(sass())
        .pipe(minifycss())
        .pipe(gulp.dest('./dist/css'))
        .pipe(notify({ message: 'Sass compile task complete' }));
});


// TODO create source map dont work
// TODO concat all files into one js dont work
gulp.task('jsmin', function() {
    return gulp.src('./js/*.js')
        // concats *.js into app.js with source map:
        .pipe(uglify('app.min.js', { outSourceMap: true }))
        .pipe(gulp.dest('./dist/js'))
        .pipe(notify({ message: 'Jsmin task complete' }));
});


// TODO jshint step - js warnings; https://github.com/spenceralger/gulp-jshint

gulp.task('jshint', function() {
    return gulp.src('./js/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));  // TODO test jshint-stylish
});

gulp.task('htmlhint', function() {
    return gulp.src("./partials/books/*.html")
        .pipe(htmlhint())
        .pipe(htmlhint.reporter());
});


// Watch Files For Changes
gulp.task('watch', function() {
    //gulp.watch('./js/*.js', ['jsmin']);
    gulp.watch('./scss/*.scss', ['sass']);
});

gulp.task('clean', function() {
    return gulp.src(['./dist/css', 'dist/js', './coverage-report-html'], {read: false})
        .pipe(clean());
});
