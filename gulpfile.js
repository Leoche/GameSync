var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var autoprefixer = require('autoprefixer-stylus');
var browserSync = require('browser-sync').create();
var nodemon = require('gulp-nodemon');

var paths = {
  scripts: ['src/js/libs/*','src/js/main.js'],
  htmls: 'src/*.html',
  images: 'src/imgs/**/*',
  styles:'src/css/*',
};

gulp.task('images', function(){
  return gulp.src(paths.images)
    .pipe(gulp.dest('dist/imgs'))
  .pipe(browserSync.stream());
});

gulp.task('styles', function(){
  return gulp.src(paths.styles)
      .pipe($.plumber())
    .pipe($.stylus({
      compress: true,
	  use: [autoprefixer('> 5%')]
    }))
    .pipe($.concat('style.min.css'))
    .pipe(gulp.dest('dist/css'))
  .pipe(browserSync.stream());
});

gulp.task('htmls', function(){
  return gulp.src(paths.htmls)
      .pipe(gulp.dest('dist'))
    .pipe(browserSync.stream());
});
gulp.task('scripts', function(){
  return gulp.src(paths.scripts)
      .pipe($.plumber())
      .pipe($.uglify())
      .pipe($.concat('script.min.js'))
      .pipe(gulp.dest('dist/js'))
    .pipe(browserSync.stream());
});

gulp.task('watch', function() {
  gulp.watch(paths.scripts, ['scripts']);
  gulp.watch(paths.images, ['images']);
  gulp.watch(paths.htmls, ['htmls']);
  gulp.watch(paths.others, ['others']);
});

gulp.task('browser-sync', ['styles'], function() {
    browserSync.init({
        server: {
            baseDir: "./dist"
        }
    });
  gulp.watch(paths.styles, ['styles']);
});
gulp.task("default", ['browser-sync','watch', 'htmls','scripts', 'images']);