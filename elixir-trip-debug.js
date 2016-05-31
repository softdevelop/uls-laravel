var gulp = require('gulp');
var shell = require('gulp-shell');
var stripDebug = require('gulp-strip-debug');
var Elixir = require('laravel-elixir');

var Task = Elixir.Task;

Elixir.extend('tripdebug', function(src) {
    new Task('tripdebug', function() {
        return gulp.src(src)
		.pipe(stripDebug())
		.pipe(gulp.dest('public/app/pages'));
    });

});