var gulp = require('gulp');
var yargs = require('yargs');
var build = require('./build');
var func = require('./helpers');

// merge with default parameters
var args = Object.assign({
    prod: false,
    exclude: '',
    theme: '',
    demo: '',
    path: '',
}, yargs.argv);

if (args.prod !== false) {
    // force disable debug for production
    build.config.debug = false;
    build.config.compile = Object.assign(build.config.compile, {
        'jsUglify': true,
        'cssMinify': true,
        'jsSourcemaps': false,
        'cssSourcemaps': false,
    });
}

// task to bundle js/css
gulp.task('build-bundle', function (cb) {
    //exclude by demo
    if (args.exclude !== '' && typeof args.exclude === 'string') {
        var exclude = args.exclude.split(',');
        exclude.forEach(function (demo) {
            delete build.build.demos[demo];
        });
    }

    func.objectWalkRecursive(build.build, function (val, key) {
        if (val.hasOwnProperty('src')) {
            if (val.hasOwnProperty('bundle')) {
                func.bundle(val);
            }
            if (val.hasOwnProperty('output')) {
                func.output(val);
            }
        }
    });
    cb();
});

var tasks = ['clean'];
tasks.push('build-bundle');

// entry point
gulp.task('default', gulp.series(tasks));

// build default and copy demo from src to dist folder
var buildTasks = ['build-bundle'];
gulp.task('build', gulp.series(buildTasks));
