const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const cleanCSS = require("gulp-clean-css");
const uglify = require("gulp-uglify");
const rename = require("gulp-rename");

const paths = {
  scss: "./src/scss/**/*.scss",
  css: "./build/css/",
  js: "./src/js/**/*.js",
  jsDest: "./build/js/",
};

function styles() {
  return gulp
    .src(paths.scss)
    .pipe(sass().on("error", sass.logError))
    .pipe(gulp.dest(paths.css))
    .pipe(cleanCSS())
    .pipe(
      rename({
        suffix: ".min",
      })
    )
    .pipe(gulp.dest(paths.css));
}

// Task to minify JavaScript
function scripts() {
  return gulp
    .src(paths.js) // Input: JS files
    .pipe(uglify()) // Minify JavaScript
    .pipe(
      rename({
        suffix: ".min",
      })
    ) // Rename to *.min.js
    .pipe(gulp.dest(paths.jsDest)); // Save minified JS
}

// Watch task
function watchFiles() {
  gulp.watch(paths.scss, styles); // Watch SCSS files
  gulp.watch(paths.js, scripts); // Watch JS files
}

exports.default = gulp.series(gulp.parallel(styles, scripts), watchFiles);
