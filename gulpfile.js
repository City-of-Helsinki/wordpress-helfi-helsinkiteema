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
  adminStyles: 'assets/admin/styles',
	footerScripts: 'assets/scripts/footer',
  headerScripts: 'assets/scripts/header',
  adminScripts: 'assets/scripts/admin'
};

const SOURCE = {
  footerScripts: [
    'src/js/footer/*.js'
  ],
  headerScripts: [
    'src/js/header/*.js'
  ],
  adminScripts: [
    'src/js/admin/*.js'
  ],
  publicStyles: 'src/scss/**/*.scss',
  adminStyles: 'src/admin/scss/**/*.scss'
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


gulp.task('footerscripts', function(){
  return gulp.src(SOURCE.footerScripts)
    .pipe(concat('scripts.js'))
		.pipe(gulp.dest(ASSETS.footerScripts))
    .pipe(babel({
      presets: ["@babel/preset-env"]
    }))
    .pipe(uglify())
    .pipe(rename('scripts.min.js'))
    .pipe(gulp.dest(ASSETS.footerScripts));
});

gulp.task('headerscripts', function(){
  return gulp.src(SOURCE.headerScripts)
    .pipe(concat('scripts.js'))
		.pipe(gulp.dest(ASSETS.headerScripts))
    .pipe(babel({
      presets: ["@babel/preset-env"]
    }))
    .pipe(uglify())
    .pipe(rename('scripts.min.js'))
    .pipe(gulp.dest(ASSETS.headerScripts));
});

gulp.task('adminscripts', function(){
  return gulp.src(SOURCE.adminScripts)
    .pipe(concat('scripts.js'))
		.pipe(gulp.dest(ASSETS.adminScripts))
    .pipe(babel({
      presets: ["@babel/preset-env"]
    }))
    .pipe(uglify())
    .pipe(rename('scripts.min.js'))
    .pipe(gulp.dest(ASSETS.adminScripts));
});

gulp.task('publicStyles', function() {
  return gulp.src(SOURCE.publicStyles)
    .pipe(sass(sassOptions))
		.pipe(gulp.dest(ASSETS.all))
    .pipe(prefix())
    .pipe(cleanCSS(cssOptions))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(ASSETS.all))
});

gulp.task('adminStyles', function() {
  return gulp.src(SOURCE.adminStyles)
    .pipe(sass(sassOptions))
		.pipe(gulp.dest(ASSETS.adminStyles))
    .pipe(prefix())
    .pipe(cleanCSS(cssOptions))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(ASSETS.adminStyles))
});

gulp.task('scripts', gulp.parallel('footerscripts', 'headerscripts', 'adminscripts'));
gulp.task('styles', gulp.parallel('publicStyles', 'adminStyles'));


gulp.task('watch',function() {
  gulp.watch(SOURCE.styles,gulp.parallel('styles'));
  gulp.watch(SOURCE.footerScripts, gulp.parallel('footerscripts'));
  gulp.watch(SOURCE.headerScripts, gulp.parallel('headerscripts'));
  gulp.watch(SOURCE.adminScripts, gulp.parallel('adminscripts'));
});

gulp.task('default', gulp.parallel('styles', 'footerscripts', 'headerscripts', 'adminscripts'));
