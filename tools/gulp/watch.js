var gulp = require('gulp');
var build = require('./build');

gulp.task('watch', function() {
  return gulp.watch([build.config.path.src + '/**/*.js', build.config.path.src + '/**/*.scss'], gulp.series('build-bundle'));
});

gulp.task('watch:scss', function() {
  return gulp.watch(build.config.path.src + '/**/*.scss', gulp.parallel('build-bundle'));
});

gulp.task('watch:js', function() {
  return gulp.watch(build.config.path.src + '/**/*.js', gulp.parallel('build-bundle'));
});