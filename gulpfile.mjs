'use strict';

import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
import gulp from 'gulp';
import rename from 'gulp-rename';
import cleanCSS from 'gulp-clean-css';
import prefix from 'gulp-autoprefixer';
import concat from 'gulp-concat';
import uglify from 'gulp-uglify';
import babel from 'gulp-babel';

const sass = gulpSass(dartSass);

const sassOptions = {
  outputStyle: 'compressed'
};

const cssOptions = {
	level: 2,
	format: {
		semicolonAfterLastProperty: true
	}
};

const ASSETS = {
  all:     'assets',
	styles:  'assets/styles/',
  adminStyles: 'assets/admin/styles',
	footerScripts: 'assets/scripts/footer',
  headerScripts: 'assets/scripts/header',
  adminScripts: 'assets/scripts/admin',
  notifications: 'partials/notification/js'
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
  notifications: [
    'src/js/notifications/*.js'
  ],
  publicStyles: 'src/scss/**/*.scss',
  adminStyles: 'src/admin/scss/**/*.scss'
}

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

gulp.task('notifications', function(){
  return gulp.src(SOURCE.notifications)
    .pipe(concat('notifications.php'))
    .pipe(gulp.dest(ASSETS.notifications))
    .pipe(babel({
      presets: ["@babel/preset-env"]
    }))
    .pipe(uglify())
    .pipe(rename('notifications.min.php'))
    .pipe(gulp.dest(ASSETS.notifications));
})

gulp.task('publicStyles', function() {
  return gulp.src(SOURCE.publicStyles)
    .pipe(sass(sassOptions).on('error', sass.logError))
    .pipe(gulp.dest(ASSETS.all))
    .pipe(prefix())
    .pipe(cleanCSS(cssOptions))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(ASSETS.all));
});

gulp.task('adminStyles', function() {
  return gulp.src(SOURCE.adminStyles)
    .pipe(sass(sassOptions).on('error', sass.logError))
    .pipe(gulp.dest(ASSETS.adminStyles))
    .pipe(prefix())
    .pipe(cleanCSS(cssOptions))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(ASSETS.adminStyles));
});

gulp.task(
  'scripts',
  gulp.parallel(
    'footerscripts',
    'headerscripts',
    'adminscripts',
    'notifications'
  )
);

gulp.task(
  'styles',
  gulp.parallel(
    'publicStyles',
    'adminStyles'
  )
);

gulp.task('watch', function() {
  gulp.watch(SOURCE.publicStyles, gulp.parallel('styles'));
  gulp.watch(SOURCE.footerScripts, gulp.parallel('footerscripts'));
  gulp.watch(SOURCE.headerScripts, gulp.parallel('headerscripts'));
  gulp.watch(SOURCE.adminScripts, gulp.parallel('adminscripts'));
  gulp.watch(SOURCE.notifications, gulp.parallel('notifications'));
});

gulp.task(
  'default',
  gulp.parallel(
    'styles',
    'footerscripts',
    'headerscripts',
    'adminscripts',
    'notifications'
  )
);
