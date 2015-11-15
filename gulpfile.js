// Include gulp
var gulp = require('gulp'),
  concat = require('gulp-concat'),
  uglify = require('gulp-uglify'),
  autoprefixer = require('gulp-autoprefixer'),
  rename = require('gulp-rename'),
  plumber = require('gulp-plumber'),
  cache = require('gulp-cache'),
  jshint = require('gulp-jshint'),
  minifyCSS = require('gulp-minify-css'),
  handlebars = require('gulp-handlebars'),
  sass = require('gulp-sass'),
  wrap = require('gulp-wrap'),
  declare = require('gulp-declare'),
  notify = require("gulp-notify"),
  browserSync = require('browser-sync').create();


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
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
});

// Handle styles
gulp.task('sass', function () {
  return gulp.src('src/style/*.scss')
    .pipe(plumber({
      errorHandler: sassErrorAlert
    }))
    .pipe(sass())
    .pipe(autoprefixer())
    .pipe(minifyCSS())
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
});

// Compile templates
gulp.task('templates', function () {
  gulp.src('src/handlebars/*.handlebars')
    .pipe(plumber({
      errorHandler: handlebarsErrorAlert
    }))
    .pipe(handlebars())
    .pipe(wrap('Handlebars.template(<%= contents %>)'))
    .pipe(declare({
      namespace: 'MyApp.templates',
      noRedeclare: true, // Avoid duplicate declarations 
    }))
    .pipe(concat('templates.js'))
    .pipe(uglify())
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
});

// Browser Sync
gulp.task('browser-sync', function () {
  browserSync.init({
    proxy: "localhost:8888",
    open: false
  });
});

// Watch for changes in files
gulp.task('watch', function () {
  // Watch .js files
  gulp.watch('src/js/*.js', ['scripts']);
  // Watch .scss files
  gulp.watch('src/style/*.scss', ['sass']);
  // Watch templates
  gulp.watch('src/handlebars/*.handlebars', ['templates']);
});

// Default Task
gulp.task('default', ['scripts', 'sass', 'watch', 'templates', 'browser-sync']);

function sassErrorAlert(error) {
  notify.onError({
    title: "SCSS Error",
    message: error.message,
    sound: "Submarine"
  })(error); //Error Notification
  console.log(error.toString()); //Prints Error to Console
  this.emit("end"); //End function
};

function handlebarsErrorAlert(error) {
  notify.onError({
    title: "Handlebars Error",
    message: error.message,
    sound: "Ping"
  })(error); //Error Notification
  console.log(error.toString()); //Prints Error to Console
  this.emit("end"); //End function
};