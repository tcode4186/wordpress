var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync');
var connect = require('gulp-connect-php');
var rename = require('gulp-rename');
var cssnano = require('gulp-cssnano');
var runSequence = require('run-sequence');



// Start browserSync server
gulp.task('browserSync', function() {
    connect.server({}, function (){
        browserSync({
            proxy: 'localhost/wordpress-gulp'
        });
    });
})


gulp.task('sass', function() {
    return gulp.src('../css/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(cssnano())
        .pipe(rename('style.min.css'))
        .pipe(gulp.dest('../css'))

        .pipe(browserSync.reload({ // Reloading with Browser Sync
            stream: true
        }));
})


gulp.task('watch', function() {
    gulp.watch('../css/*.scss', ['sass']);
    gulp.watch('../*.php').on('change', browserSync.reload);
    gulp.watch('../js/**/*.js', browserSync.reload);
    gulp.watch('../**/*.php').on('change', browserSync.reload());
})


gulp.task('default', function(callback) {
    runSequence(['sass', 'browserSync'], 'watch',
        callback
    )
})
