const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');

// Paths
const paths = {
  scss: './src/scss/**/*.scss',
  css: './build/css/',
};

// Task to compile SCSS to CSS and minify it
function styles() {
  return gulp
    .src(paths.scss) // Input: SCSS files
    .pipe(sass().on('error', sass.logError)) // Compile SCSS to CSS
    .pipe(gulp.dest(paths.css)) // Save unminified CSS
    .pipe(cleanCSS()) // Minify CSS
    .pipe(
      rename({
        suffix: '.min',
      })
    ) // Rename to *.min.css
    .pipe(gulp.dest(paths.css)); // Save minified CSS
}

// Watch task
function watchFiles() {
  gulp.watch(paths.scss, styles); // Watch SCSS files and run 'styles' on change
}

// Default task
exports.default = gulp.series(styles, watchFiles);
