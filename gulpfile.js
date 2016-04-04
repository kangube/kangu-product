//Creating all required variables needed to run the tasks
var gulp = require('gulp'),
    sass = require('gulp-sass'),
    plumber = require('gulp-plumber'),
    connect = require('gulp-connect-php'),
    concat = require('gulp-concat'),
    cssnano = require('gulp-cssnano'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    runSequence = require('run-sequence'),
    autoprefixer = require('gulp-autoprefixer'),
    livereload = require('gulp-livereload'),
    imagemin = require('gulp-imagemin');

// Setting up the server
gulp.task('connect', function() {
    console.log('starting localhost server at port 8888')
    connect.server({ base: 'public', port: 8888 });
});

// Copying all of the required image assets from the resources folder to the public folder
gulp.task('move-image-icon-dependencies', function() {
    console.log('Copying and minifying all of the required image assets from the resources folder to the public folder');
    gulp.src('resources/assets/**/*')
        .pipe(imagemin({ progressive: true }))
        .pipe(plumber())
        .pipe(gulp.dest('public/assets'));
});

// Compiling all of the custom js files into one file
// After the compile task the file will be minified
gulp.task('concat-custom-js', function() {
    console.log('Compiling and minifying all javascript files into one file');
    JavascriptCompile(JavascriptMinify);
});

// Compiling all of the sass files into one file
// After the compile task the file will be minified
gulp.task('sass', function () {
    console.log('Compiling and minifying all sass files into one file');
    SassCompile(ConcatCss);
});

// Watching the scss src folder for changes
gulp.task('watch', function () {
    console.log("Watching for changes");
    livereload.listen();
    gulp.watch("resources/scss/**/*.scss", ['sass']);
});

// All functions used by the tasks above
function JavascriptCompile(cb) {
    console.log('Concatinating all js assets into the minimum-viable-product.js file');
    gulp.src([
        ('bower_components/jquery/dist/jquery.min.js'),
        ('bower_components/foundation-sites/dist/foundation.min.js'),
        ('bower_components/what-input/what-input.min.js'),
        ('bower_components/jquery-ui/ui/core.js'),
        ('bower_components/jquery-ui/ui/datepicker.js'),
        ('bower_components/jt.timepicker/jquery.timepicker.js'),
        ('bower_components/arrive/minified/arrive.min.js'),
        ('resources/js/custom/*')
      ]).pipe(plumber())
        .pipe(concat('minimum-viable-product.js'))
        .pipe(gulp.dest('resources/js'))
        .on('end', cb);
}

function JavascriptMinify() {
    console.log('Minifying the minimum-viable-product.js file');
    return gulp.src('resources/js/minimum-viable-product.js')
        .pipe(uglify())
        .pipe(rename({ extname: '.min.js' }))
        .pipe(gulp.dest('public/js'))
        .pipe(livereload());
}

function SassCompile(cb) {
    console.log("Compiling the product and foundation sass files");
    gulp.src('resources/scss/product.scss')
        .pipe(plumber())
        .pipe(sass())
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(gulp.dest('resources/temp_css'))
        .on('end', cb);
}

function ConcatCss() {
    console.log("Concat and minify the minimum-viable-product css");
    gulp.src('resources/temp_css/product.css')
        .pipe(concat('minimum-viable-product.css'))
        .pipe(gulp.dest('resources/temp_css'))
        .pipe(cssnano())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('public/css'))
        .pipe(livereload());
}

// Running all tasks in a particular order
gulp.task('default', function () {
    gulp.start('compile', 'watch');
});

gulp.task('compile', function () {
    gulp.start('connect', 'move-image-icon-dependencies', 'concat-custom-js', 'sass');
});