// Include gulp
var gulp = require('gulp');
// Include plugins
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var autoprefixer = require('gulp-autoprefixer');
var rename = require('gulp-rename');
//var sass = require('gulp-ruby-sass');
var compass = require('gulp-compass');
var plumber = require('gulp-plumber');
var imagemin = require('gulp-imagemin');
var cache = require('gulp-cache');
var jshint = require('gulp-jshint');
var scsslint = require('gulp-scss-lint');
var minifyCSS = require('gulp-minify-css');
var handlebars = require('gulp-handlebars');
var wrap = require('gulp-wrap');
var declare = require('gulp-declare');


// Concatenate & Minify JS
gulp.task('scripts', function () {
  return gulp.src('src/js/*.js')
    .pipe(jshint())
    .pipe(jshint.reporter('default'))
    .pipe(concat('main.js'))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(uglify())
    .pipe(gulp.dest('build/js/'));
});

gulp.task('sass', function () {
  return gulp.src('src/style/main.scss')
    .pipe(plumber())
    .pipe(scsslint())
    .pipe(compass({
      css: 'build/style',
      sass: 'src/style/'
    }))
    .pipe(autoprefixer())
    .pipe(minifyCSS())
    .pipe(gulp.dest('build/style'));
});

gulp.task('images', function () {
  return gulp.src('src/img/**/*')
    .pipe(cache(imagemin({
      optimizationLevel: 5,
      progressive: true,
      interlaced: true
    })))
    .pipe(gulp.dest('build/img'));
});

gulp.task('templates', function () {
  gulp.src('src/handlebars/*.handlebars')
    .pipe(handlebars())
    .pipe(wrap('Handlebars.template(<%= contents %>)'))
    .pipe(declare({
      namespace: 'MyApp.templates',
      noRedeclare: true, // Avoid duplicate declarations 
    }))
    .pipe(concat('templates.js'))
    .pipe(uglify())
    .pipe(gulp.dest('build/js/'));
});

// Watch for changes in files
gulp.task('watch', function () {
  // Watch .js files
  gulp.watch('src/js/*.js', ['scripts']);
  // Watch .scss files
  gulp.watch('src/style/main.scss', ['sass']);
  // Watch image files
  gulp.watch('src/img/**/*', ['images']);
  // Watch templates
  gulp.watch('src/handlebars/*.handlebars', ['templates']);
});

// Default Task
gulp.task('default', ['scripts', 'sass', 'images', 'watch', 'templates']);