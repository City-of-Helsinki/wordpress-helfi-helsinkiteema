var gulp        = require('gulp'),
    sass        = require('gulp-sass')(require('sass')),
    rename      = require('gulp-rename'),
		cleanCSS = require('gulp-clean-css');
    prefix      = require('gulp-autoprefixer'),
    concat      = require('gulp-concat'),
    uglify      = require('gulp-uglify'),
    babel       = require('gulp-babel');

const ASSETS = {
  all:     'assets',
	styles:  'assets/styles/',
	scripts: 'assets/scripts/'
};

const SOURCE = {
  scripts: [
    'src/js/**/*.js'
  ],
  styles: 'src/scss/**/*.scss',
}

var sassOptions = {
  outputStyle: 'compressed'
};

var cssOptions = {
	level: 2,
	format: {
		semicolonAfterLastProperty: true
	}
};

gulp.task('scripts', function(){
  return gulp.src(SOURCE.scripts)
    .pipe(concat('scripts.js'))
		.pipe(gulp.dest(ASSETS.all))
    .pipe(babel({
      presets: ["@babel/preset-env"]
    }))
    .pipe(uglify())
    .pipe(rename('scripts.min.js'))
    .pipe(gulp.dest(ASSETS.all));
});

gulp.task('styles', function() {
  return gulp.src(SOURCE.styles)
    .pipe(sass(sassOptions))
		.pipe(gulp.dest(ASSETS.all))
    .pipe(prefix())
    .pipe(cleanCSS(cssOptions))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(ASSETS.all))
});

gulp.task('watch',function() {
  gulp.watch(SOURCE.styles,gulp.parallel('styles'));
  gulp.watch(SOURCE.scripts, gulp.parallel('scripts'));
});

gulp.task('default', gulp.parallel('styles', 'scripts'));
