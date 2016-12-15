// Include gulp
const gulp = require('gulp')
const concat = require('gulp-concat')
const uglify = require('gulp-uglify')
const autoprefixer = require('gulp-autoprefixer')
const rename = require('gulp-rename')
const plumber = require('gulp-plumber')
const cache = require('gulp-cache')
const cssnano = require('gulp-cssnano')
const sass = require('gulp-sass')
const wrap = require('gulp-wrap')
const declare = require('gulp-declare')
const notify = require('gulp-notify')
const imagemin = require('gulp-imagemin')
const pngquant = require('imagemin-pngquant')
const changed = require('gulp-changed')
const parker = require('gulp-parker')
const fontgen = require('gulp-fontgen')
const browserify = require('browserify')
const source = require('vinyl-source-stream')
const buffer = require('vinyl-buffer')
const stripDebug = require('gulp-strip-debug')
const gulpif = require('gulp-if')
const argv = require('yargs').argv



const browserSync = require('browser-sync').create()

// Build javascript
gulp.task('scripts', function () {

  return browserify('./src/js/app.js', {debug: true})
    .bundle()
    .pipe(source('app.min.js'))
    .pipe(buffer())
    .pipe(gulpif(argv.production, uglify()))
    .pipe(gulpif(argv.production, stripDebug()))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());

});

// Handle styles
gulp.task('sass', function () {
  return gulp.src('src/style/style.scss')
    .pipe(changed('./'))
    .pipe(plumber({
      errorHandler: sassErrorAlert
    }))
    .pipe(sass())
    .pipe(gulpif(argv.production, autoprefixer()))
    .pipe(gulpif(argv.production, cssnano()))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
});

// Browser Sync
gulp.task('browser-sync', function () {
  browserSync.init({
    proxy: 'localhost:8888',
    open: false
  });
});

// Images
gulp.task('images', () => {
  return gulp.src('src/img/**/*')
    .pipe(changed('img'))
    .pipe(imagemin({
      progressive: true,
      svgoPlugins: [{
        removeViewBox: false
        }],
      use: [pngquant()]
    }))
    .pipe(gulp.dest('img'));
});

// Generate webfonts
gulp.task('font', function () {
  return gulp.src("./src/fonts/*.{ttf,otf}")
    .pipe(fontgen({
      dest: "./fonts/"
    }));
});

// Watch for changes in files
gulp.task('watch', function () {

  // Watch .js files
  gulp.watch('src/js/*.js', ['scripts']);

  // Watch .php files
  gulp.watch('*.php', browserSync.reload);

  // Watch .scss files
  gulp.watch('src/style/**/*.scss', ['sass']);

  // Watch images
  gulp.watch('src/img/*', ['images']);

  // Watch fonts
  gulp.watch('src/fonts/*.{ttf,otf}"', ['font']);

});

// Analyze CSS
gulp.task('parker', function () {
  return gulp.src('./style.css')
    .pipe(parker());
});

// Default Task
gulp.task('default', ['scripts', 'sass', 'watch', 'browser-sync', 'images']);

function sassErrorAlert(error) {
  notify.onError({
    title: 'SCSS Error',
    message: error.message,
    sound: 'Submarine'
  })(error); //Error Notification
  console.log(error.toString()); //Prints Error to Console
  this.emit('end'); //End function
};

function handlebarsErrorAlert(error) {
  notify.onError({
    title: 'Handlebars Error',
    message: error.message,
    sound: 'Ping'
  })(error); //Error Notification
  console.log(error.toString()); //Prints Error to Console
  this.emit('end'); //End function
};

function handleErrors() {
  var args = Array.prototype.slice.call(arguments);
  notify.onError({
    title: "Compile Error",
    message: "<%= error %>"
  }).apply(this, args);
  this.emit('end'); // Keep gulp from hanging on this task
}
