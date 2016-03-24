var gulp = require('gulp');
var exec = require('exec');

var paths = {
  jobs: ['../uploads/**/*.fds'],
  parcel: ['../parcel.php']
};

var runCommand = "php -r 'require \"" + paths.parcel + "\"; P::run();'";

gulp.task('jobs', function () {
  exec([runCommand], function(err, out, code) {
    if (err instanceof Error)
      throw err;
    process.stderr.write(err);
    process.stdout.write(out);
    process.exit(code);
  });
});

gulp.task('watch', function() {
  gulp.watch(paths.jobs, ['jobs']);
});

gulp.task('default', ['watch', 'jobs']);
