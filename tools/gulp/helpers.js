'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var rewrite = require('gulp-rewrite-css');
var concat = require('gulp-concat');
var lazypipe = require('lazypipe');
var gulpif = require('gulp-if');
var uglify = require('gulp-uglify-es').default;
var sourcemaps = require('gulp-sourcemaps');
var build = require('./build');
var path = require('path');
var filter = require('gulp-filter');
var autoprefixer = require('gulp-autoprefixer');
var cleancss = require('gulp-clean-css');
var yargs = require('yargs');

// merge with default parameters
var args = Object.assign({
    prod: false,
    sass: false,
    js: false,
    media: false,
}, yargs.argv);

var allAssets = false;
if (args.sass === false && args.js === false && args.media === false) {
    allAssets = true;
}

if (args.prod !== false) {
    // force disable debug for production
    build.config.debug = false;
    build.config.compile.jsUglify = true;
    build.config.compile.cssMinify = true;
}

module.exports = {

    // default variable config
    config: Object.assign({}, {
        demo: '',
        debug: true,
        compile: {
            jsUglify: false,
            cssMinify: false,
            jsSourcemaps: false,
            cssSourcemaps: false,
        },
    }, build.config),

    /**
     * Walk into object recursively
     * @param array
     * @param funcname
     * @param userdata
     * @returns {boolean}
     */
    objectWalkRecursive: function (array, funcname, userdata) {
        if (!array || typeof array !== 'object') {
            return false;
        }
        if (typeof funcname !== 'function') {
            return false;
        }
        for (var key in array) {
            // apply "funcname" recursively only on object
            if (Object.prototype.toString.call(array[key]) === '[object Object]') {
                var funcArgs = [array[key], funcname];
                if (arguments.length > 2) {
                    funcArgs.push(userdata);
                }
                if (module.exports.objectWalkRecursive.apply(null, funcArgs) === false) {
                    return false;
                }
                // continue
            }
            try {
                if (arguments.length > 2) {
                    funcname(array[key], key, userdata);
                } else {
                    funcname(array[key], key);
                }
            } catch (e) {
                return false;
            }
        }
        return true;
    },

    /**
     * Add JS compilation options to gulp pipe
     */
    jsChannel: function () {
        var config = this.config.compile;
        return lazypipe().pipe(function () {
            return gulpif(config.jsSourcemaps, sourcemaps.init({loadMaps: true, debug: config.debug}));
        }).pipe(function () {
            return gulpif(config.jsUglify, uglify());
        }).pipe(function () {
            return gulpif(config.jsSourcemaps, sourcemaps.write('./'));
        });
    },

    /**
     * Add CSS compilation options to gulp pipe
     */
    cssChannel: function (includePaths) {
        var config = this.config.compile;
        return lazypipe().pipe(function () {
            return gulpif(config.cssSourcemaps, sourcemaps.init({loadMaps: true, debug: config.debug}));
        }).pipe(function () {
            return sass({
                errLogToConsole: true,
                includePaths: includePaths,
                // outputStyle: config.cssMinify ? 'compressed' : '',
            }).on('error', sass.logError);
        }).pipe(function () {
            return gulpif(config.cssMinify, cleancss());
        }).pipe(function () {
            return gulpif(true, autoprefixer({
                overrideBrowserslist: ['last 2 versions'],
                cascade: false,
            }));
        }).pipe(function () {
            return gulpif(config.cssSourcemaps, sourcemaps.write('./'));
        });
    },

    /**
     * Multiple output paths by output config
     * @param path
     * @param outputFile
     * @param type
     * @returns {*}
     */
    outputChannel: function (path, outputFile, type) {
        if (!allAssets) {
            if (args.sass && ['styles', 'styles-by-demo'].indexOf(type) === -1) {
                return lazypipe().pipe(function () {
                    // noop
                });
            }
            if (args.js && ['scripts'].indexOf(type) === -1) {
                return lazypipe().pipe(function () {
                    // noop
                });
            }
            if (args.media && ['media', 'fonts', 'images'].indexOf(type) === -1) {
                return lazypipe().pipe(function () {
                    // noop
                });
            }
        }

        if (typeof path === 'undefined') {
            console.log('Output path not defined');
        }
        if (typeof outputFile === 'undefined') {
            outputFile = '';
        }

        var piping = lazypipe();

        var regex = new RegExp(/\{\$.*?\}/);
        var matched = path.match(regex);
        if (matched) {
            var outputs = build.config.dist;
            outputs.forEach(function (output) {
                if (output.indexOf('/**/') !== -1) {
                    module.exports.getDemos().forEach(function (demo) {
                        var outputPath = path.replace('**', demo).replace(matched[0], output.replace('**', demo)).replace(outputFile, '');
                        // exclude unrelated demo assets
                        if (outputPath.indexOf('/assets/demo/') !== -1 && outputPath.indexOf('/assets/demo/' + demo) === -1) {
                            var f = filter(outputPath, {restore: true});
                            piping = piping.pipe(function () {
                                return f;
                            });
                            (function (_output) {
                                piping = piping.pipe(function () {
                                    return gulp.dest(_output);
                                });
                            })(outputPath);
                            piping = piping.pipe(function () {
                                return f.restore;
                            });
                        } else {
                            (function (_output) {
                                piping = piping.pipe(function () {
                                    return gulp.dest(_output);
                                });
                            })(outputPath);
                        }
                    });
                } else {
                    if (path.indexOf('/**/') !== -1) {
                        module.exports.getDemos().forEach(function (demo) {
                            var outputPath = path.replace('**', demo).replace(matched[0], output).replace(outputFile, '');
                            (function (_output) {
                                piping = piping.pipe(function () {
                                    return gulp.dest(_output);
                                });
                            })(outputPath);
                        });
                    } else {
                        var outputPath = path.replace(matched[0], output).replace(outputFile, '');
                        (function (_output) {
                            piping = piping.pipe(function () {
                                return gulp.dest(_output);
                            });
                        })(outputPath);
                    }
                }
            });
        }

        return piping;
    },

    /**
     * Convert string path to actual path
     * @param path
     * @returns {*}
     */
    dotPath: function (path) {
        var regex = new RegExp(/\{\$(.*?)\}/),
            dot = function (obj, i) {
                return obj[i];
            };
        var matched = path.match(regex);
        if (matched) {
            var realpath = matched[1].split('.').reduce(dot, build);
            return path = path.replace(matched[0], realpath);
        }

        return path;
    },

    /**
     * Convert multiple paths
     * @param paths
     */
    dotPaths: function (paths) {
        paths.forEach(function (path, i) {
            paths[i] = module.exports.dotPath(path);
        });
    },

    /**
     * Css path rewriter when bundle files moved
     * @param folder
     */
    cssRewriter: function (folder) {
        var imgRegex = new RegExp(/\.(gif|jpg|jpeg|tiff|png|ico)$/i);
        // var fontRegex = new RegExp(/\.(otf|eot|svg|ttf|woff|woff2)$/i);
        var vendorGlobalRegex = new RegExp(/vendors\/global/i);
        var config = this.config;

        return lazypipe().pipe(function () {
            // rewrite css relative path
            return rewrite({
                destination: folder,
                debug: config.debug,
                adaptPath: function (ctx) {
                    var isCss = ctx.sourceFile.match(/\.[css]+$/i);
                    // process css only
                    if (isCss[0] === '.css') {
                        var pieces = ctx.sourceDir.split(/\\|\//);

                        var vendor = '';
                        if (vendorGlobalRegex.test(folder)) {
                            // only vendors/base pass this
                            vendor = pieces[pieces.indexOf('node_modules') + 1];
                            if (pieces.indexOf('node_modules') === -1) {
                                vendor = pieces[pieces.indexOf('vendors') + 1];
                            }
                        }

                        var file = path.basename(ctx.targetFile);

                        var extension = 'fonts/';
                        if (imgRegex.test(file)) {
                            extension = 'images/';
                        }

                        return path.join(extension + vendor, file);
                    }
                },
            });
        });
    },

    /**
     * Get end filename from path
     * @param path
     * @returns {string}
     */
    baseFileName: function (path) {
        var maybeFile = path.split('/').pop();
        if (maybeFile.indexOf('.') !== -1) {
            return maybeFile;
        }
        return '';
    },

    /**
     * Bundle
     * @param bundle
     */
    bundle: function (bundle) {
        var _self = this;
        var streams = [];
        var stream;

        if (bundle.hasOwnProperty('src') && bundle.hasOwnProperty('bundle')) {

            // for images & fonts as per vendor
            if ('mandatory' in bundle.src && 'optional' in bundle.src) {
                var vendors = {};

                for (var key in bundle.src) {
                    if (!bundle.src.hasOwnProperty(key)) {
                        continue;
                    }
                    vendors = Object.assign(vendors, bundle.src[key]);
                }

                for (var vendor in vendors) {
                    if (!vendors.hasOwnProperty(vendor)) {
                        continue;
                    }

                    var vendorObj = vendors[vendor];

                    for (var type in vendorObj) {
                        if (!vendorObj.hasOwnProperty(type)) {
                            continue;
                        }

                        _self.dotPaths(vendorObj[type]);

                        switch (type) {
                            case 'fonts':
                                stream = gulp.src(vendorObj[type], {allowEmpty: true});
                                var output = _self.outputChannel(bundle.bundle[type] + '/' + vendor, undefined, type)();
                                if (output) {
                                    stream.pipe(output);
                                }
                                streams.push(stream);
                                break;
                            case 'images':
                                stream = gulp.src(vendorObj[type], {allowEmpty: true});
                                var output = _self.outputChannel(bundle.bundle[type] + '/' + vendor, undefined, type)();
                                if (output) {
                                    stream.pipe(output);
                                }
                                streams.push(stream);
                                break;
                        }
                    }
                }
            }

            // flattening array
            if (!('styles' in bundle.src) && !('scripts' in bundle.src)) {
                var src = {styles: [], scripts: []};
                _self.objectWalkRecursive(bundle.src, function (paths, type) {
                    switch (type) {
                        case 'styles':
                        case 'scripts':
                            src[type] = src[type].concat(paths);
                            break;
                        case 'images':
                            // images for mandatory and optional vendor already processed
                            if (!'mandatory' in bundle.src || !'optional' in bundle.src) {
                                src[type] = src[type].concat(paths);
                            }
                            break;
                    }
                });
                bundle.src = src;
            }

            for (var type in bundle.src) {
                if (!bundle.src.hasOwnProperty(type)) {
                    continue;
                }
                // skip if not array
                if (Object.prototype.toString.call(bundle.src[type]) !== '[object Array]') {
                    continue;
                }
                // skip if no bundle output is provided
                if (typeof bundle.bundle[type] === 'undefined') {
                    continue;
                }

                _self.dotPaths(bundle.src[type]);
                var outputFile = _self.baseFileName(bundle.bundle[type]);

                switch (type) {
                    case 'styles':
                        if (bundle.bundle.hasOwnProperty(type)) {

                            // default css bundle
                            stream = gulp.src(bundle.src[type], {allowEmpty: true}).pipe(_self.cssRewriter(bundle.bundle[type])()).pipe(concat(outputFile)).pipe(_self.cssChannel()());
                            var output = _self.outputChannel(bundle.bundle[type], outputFile, type)();
                            if (output) {
                                stream.pipe(output);
                            }
                            streams.push(stream);
                        }
                        break;

                    case 'scripts':
                        if (bundle.bundle.hasOwnProperty(type)) {
                            stream = gulp.src(bundle.src[type], {allowEmpty: true}).pipe(concat(outputFile)).pipe(_self.jsChannel()());
                            var output = _self.outputChannel(bundle.bundle[type], outputFile, type)();
                            if (output) {
                                stream.pipe(output);
                            }
                            streams.push(stream);
                        }

                        break;

                    case 'images':
                        if (bundle.bundle.hasOwnProperty(type)) {
                            stream = gulp.src(bundle.src[type], {allowEmpty: true});
                            var output = _self.outputChannel(bundle.bundle[type], undefined, type)();
                            if (output) {
                                stream.pipe(output);
                            }
                            streams.push(stream);
                        }
                        break;
                }
            }
        }

        return streams;
    },

    /**
     * Copy source to output destination
     * @param bundle
     */
    output: function (bundle) {
        var _self = this;
        var stream;
        var streams = [];

        if (bundle.hasOwnProperty('src') && bundle.hasOwnProperty('output')) {
            for (var type in bundle.src) {
                if (!bundle.src.hasOwnProperty(type)) {
                    continue;
                }

                _self.dotPaths(bundle.src[type]);

                if (bundle.output.hasOwnProperty(type)) {
                    switch (type) {
                        case 'styles':
                            // non rtl styles
                            stream = gulp.src(bundle.src[type], {allowEmpty: true}).pipe(_self.cssChannel()());
                            var output = _self.outputChannel(bundle.output[type], undefined, type)();
                            if (output) {
                                stream.pipe(output);
                            }
                            streams.push(stream);
                            break;
                        case 'styles-by-demo':
                            // custom scss with suffix demos
                            module.exports.getDemos().forEach(function () {
                                // custom page scss
                                stream = gulp.src(bundle.src[type], {allowEmpty: true}).pipe(_self.cssChannel([
                                    '../resources/assets/src/sass/theme/demos/', // release default package
                                ])());// pipe(rename({ suffix: '.' + demo })).

                                var output = _self.outputChannel(bundle.output[type], undefined, type)();
                                if (output) {
                                    stream.pipe(output);
                                }
                                streams.push(stream);
                            });
                            break;
                        case 'scripts':
                            stream = gulp.src(bundle.src[type], {allowEmpty: true}).pipe(_self.jsChannel()());
                            var output = _self.outputChannel(bundle.output[type], undefined, type)();
                            if (output) {
                                stream.pipe(output);
                            }
                            streams.push(stream);
                            break;
                        default:
                            stream = gulp.src(bundle.src[type], {allowEmpty: true});
                            var output = _self.outputChannel(bundle.output[type], undefined, type)();
                            if (output) {
                                stream.pipe(output);
                            }
                            streams.push(stream);
                            break;
                    }
                }
            }
        }

        return streams;
    },

    getDemos: function () {
        var demos = Object.keys(build.build.demos);
        return demos;
    },
};
