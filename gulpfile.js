'use strict';

var browserify  = require('browserify');
var concat      = require('gulp-concat');
var es          = require('event-stream');
var gulp        = require('gulp');
var gutil       = require('gulp-util');
var livereload  = require('gulp-livereload');
var minifyCss   = require('gulp-minify-css');
var ngAnnotate  = require('gulp-ng-annotate');
var notifier    = require('node-notifier');
var phpunit     = require('gulp-phpunit');
var source      = require('vinyl-source-stream');
var streamify   = require('gulp-streamify');
var uglify      = require('gulp-uglify');

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
  },
  img: {
    src: './src/img/**/*',
    dest: './public/img/'
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
    .pipe(source(config.scripts.filename))
    .pipe(ngAnnotate())
    .pipe(livereload());

  if (production)
    pipeline = pipeline.pipe(streamify(uglify()));

  return pipeline.pipe(gulp.dest(config.scripts.dest));
});

/**
 * Templates
 * ---------
 */
gulp.task('templates', function() {
  var src = gulp.src(config.templates.src);

  return src
    .pipe(gulp.dest(config.templates.dest))
    .pipe(livereload());
});

/**
 * Styles
 * ---------
 */
gulp.task('styles', function() {
  var src = gulp.src(config.styles.src)
    .pipe(concat('bundle.css'))
    .pipe(livereload());

  if (production)
    src.pipe(minifyCss());

  return src.pipe(gulp.dest(config.styles.dest));

});

/**
 * Bootstrap minified css & fonts
 * ---------
 */
gulp.task('bootstrap', function() {
  return es.concat(
    gulp.src('./bower_components/bootstrap/dist/css/bootstrap.min.css')
      .pipe(gulp.dest('./public/css/')),
    gulp.src('./bower_components/bootstrap/dist/fonts/*')
      .pipe(gulp.dest('./public/fonts/'))
  );
});

/**
 * API
 * ---------
 */
gulp.task('api', function() {
  return es.concat(
    gulp.src(config.api.src)
      .pipe(gulp.dest(config.api.dest)),
    gulp.src('./api/.htaccess')
      .pipe(gulp.dest(config.api.dest))
  );
});

/**
 * SourceQuery & Slim
 */
gulp.task('api-lib', function() {
  return es.concat(
    gulp.src('./vendor/xpaw/php-source-query-class/SourceQuery/*')
      .pipe(gulp.dest('./public/api/class/SourceQuery/')),
    gulp.src('./vendor/slim/slim/Slim/**/*')
      .pipe(gulp.dest('./public/api/class/Slim/'))
  );
});

/**
 * Images
 * ---------
 */
gulp.task('img', function() {
  return gulp.src(config.img.src).pipe(gulp.dest(config.img.dest));
});

/**
 * PHPUnit tests
 * ---------
 */
gulp.task('phpunit', function() {
  return gulp.src('./test/phpunit.xml').pipe(phpunit());
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

gulp.task('build', ['scripts', 'templates', 'styles', 'bootstrap', 'api', 'api-lib', 'img']);
gulp.task('default', ['build', 'watch']);