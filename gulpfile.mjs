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
  admin: {
    styles: 'assets/admin/css',
    scripts: 'assets/admin/js',
  },
  editor: {
    styles: 'assets/editor/css',
    scripts: 'assets/editor/js',
  },
  public: {
    scripts: {
      header: 'assets/public/header',
      footer: 'assets/public/footer',
      notifications: 'partials/notification/js',
    },
    styles: 'assets/public',
  },
};

const SOURCE = {
  admin: {
    styles: 'src/admin/scss/**/*.scss',
    scripts: 'src/admin/js/*.js',
  },
  editor: {
    styles: 'src/editor/scss/**/*.scss',
    scripts: 'src/editor/js/*.js',
  },
  public: {
    scripts: {
      header: 'src/public/js/header/*.js',
      footer: 'src/public/js/footer/*.js',
      notifications: 'src/public/js/notifications/*.js',
    },
    styles: 'src/public/scss/**/*.scss',
  },
}

function handleScripts(source, destination) {
  return gulp.src(source)
		.pipe(concat('scripts.js'))
		.pipe(babel({
			presets: ["@babel/preset-env"]
		}))
    .pipe(gulp.dest(destination))
		.pipe(uglify())
		.pipe(rename('scripts.min.js'))
		.pipe(gulp.dest(destination));
}

function handleStyles(source, destination) {
  return gulp.src(source)
    .pipe(sass(sassOptions).on('error', sass.logError))
    .pipe(prefix())
    .pipe(cleanCSS(cssOptions))
    .pipe(gulp.dest(destination))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(destination))
}

gulp.task('adminScripts', () => handleScripts(SOURCE.admin.scripts, ASSETS.admin.scripts));
// gulp.task('adminStyles', () => handleStyles(SOURCE.admin.styles, ASSETS.admin.styles));

gulp.task('editorScripts', () => handleScripts(SOURCE.editor.scripts, ASSETS.editor.scripts));
gulp.task('editorStyles', () => handleStyles(SOURCE.editor.styles, ASSETS.editor.styles));

gulp.task('footerScripts', () => handleScripts(SOURCE.public.scripts.footer, ASSETS.public.scripts.footer));
gulp.task('headerScripts', () => handleScripts(SOURCE.public.scripts.header, ASSETS.public.scripts.header));
gulp.task('publicStyles', () => handleStyles(SOURCE.public.styles, ASSETS.public.styles));

gulp.task('notificationScripts', function(){
  return gulp.src(SOURCE.public.scripts.notifications)
    .pipe(concat('notifications.php'))
    .pipe(gulp.dest(ASSETS.public.scripts.notifications))
    .pipe(babel({
      presets: ["@babel/preset-env"]
    }))
    .pipe(uglify())
    .pipe(rename('notifications.min.php'))
    .pipe(gulp.dest(ASSETS.public.scripts.notifications));
})

gulp.task(
  'scripts',
  gulp.parallel(
    'adminScripts',
    'editorScripts',
    'footerScripts',
    'headerScripts',
    'notificationScripts',
  )
);

gulp.task(
  'styles',
  gulp.parallel(
    // 'adminStyles',
    'editorStyles',
    'publicStyles',
  )
);

gulp.task('watch', function() {
  gulp.watch(SOURCE.admin.scripts, gulp.parallel('adminScripts'));
  // gulp.watch(SOURCE.admin.styles, gulp.parallel('adminStyles'));

  gulp.watch(SOURCE.editor.scripts, gulp.parallel('editorScripts'));
  gulp.watch(SOURCE.editor.styles, gulp.parallel('editorStyles'));

  gulp.watch(SOURCE.public.scripts.footer, gulp.parallel('footerScripts'));
  gulp.watch(SOURCE.public.scripts.header, gulp.parallel('headerScripts'));
  gulp.watch(SOURCE.public.scripts.notifications, gulp.parallel('notificationScripts'));
  gulp.watch(SOURCE.public.styles, gulp.parallel('publicStyles'));
});

gulp.task(
  'default',
  gulp.parallel(
    'adminScripts',
    // 'adminStyles',
    'editorScripts',
    'editorStyles',
    'footerScripts',
    'headerScripts',
    'notificationScripts',
    'publicStyles',
  )
);
