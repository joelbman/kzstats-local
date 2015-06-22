'use strict';

var browserify  = require('browserify');
var gulp        = require('gulp');
var concat      = require('gulp-concat');
var uglify      = require('gulp-uglify');
var livereload  = require('gulp-livereload');
var gutil       = require('gulp-util');
var notifier    = require('node-notifier');
var minifyCss   = require('gulp-minify-css');
var source      = require('vinyl-source-stream');
var streamify   = require('gulp-streamify');

var production = process.env.NODE_ENV === 'production';

var config = {
  scripts: {
    src: './src/js/main.js',
    dest: './public/js/',
    watch: './src/js/**/*.js',
    filename: 'bundle.js'
  },
  templates: {
    src: './src/templates/**/*.html',
    watch: './src/templates/**/*.html',
    dest: './public/'
  },
  styles: {
    src: './src/css/**/*.css',
    watch: './src/css/**/*.css',
    dest: './public/css/'
  },
  api: {
    src: './api/**/*.php',
    watch: './api/**/*.php',
    dest: './public/api/'
  }
};

var browserifyConfig = {
  entries: [config.scripts.src],
  debug: !production,
  cache: {},
  packageCache: {}
};

function handleError(err) {
  gutil.log(err);
  gutil.beep();
  notifier.notify({
    title: 'Compile Error',
    message: err.message
  });
  return this.emit('end');
}

/**
 * JavaScript
 * ---------
 */
gulp.task('scripts', function() {
  var pipeline = browserify(browserifyConfig)
    .bundle()
    .on('error', handleError)
    .pipe(source(config.scripts.filename));

  if (production)
    pipeline = pipeline.pipe(streamify(uglify()));

  return pipeline.pipe(gulp.dest(config.scripts.destination));
});

/**
 * Templates
 * ---------
 */
gulp.task('templates', function() {
  return gulp.src(config.templates.src).pipe(gulp.dest(config.templates.dest));
});

/**
 * Styles
 * ---------
 */
gulp.task('styles', function() {
  var src = gulp.src(config.styles.src).pipe(concat('bundle.css'));

  if (production)
    src.pipe(minifyCss());

  return src.pipe(gulp.dest(config.styles.dest));

});

/**
 * API
 * ---------
 */
gulp.task('api', function() {
  return gulp.src(config.api.src).pipe(gulp.dest(config.api.dest));
});

/**
 * Watcher
 * ---------
 */
gulp.task('watch', function() {
  livereload.listen();
  gulp.watch(config.templates.watch, ['templates']);
  gulp.watch(config.styles.watch, ['styles']);
  gulp.watch(config.scripts.watch, ['scripts']);
  gulp.watch(config.api.watch, ['api']);
});

gulp.task('no-js', ['templates', 'styles']);
gulp.task('build', ['scripts', 'no-js', 'api']);
gulp.task('default', ['no-js', 'watch']);