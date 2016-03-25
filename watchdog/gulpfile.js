var gulp = require('gulp'),
    exec = require('exec'),
    watch = require('gulp-watch');

const ADD = 'add';

var paths = {
  jobs: ['../uploads/**/*.fds'],
  parcel: ['../parcel.php']
};

//var runCommand = "php -r 'require \"" + paths.parcel + "\"; P::run();'";

gulp.task('jobs', function () {

});

gulp.task('watch', function() {
  watch(paths.jobs, function (vinyl) {
    if (vinyl.event == ADD)
      console.log("Houston, we have a new FDS job");
  });
});

gulp.task('default', ['watch']);
