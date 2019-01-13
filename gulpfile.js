'use strict';

const gulp = require('gulp');
const del = require('del');

const bundle = [
    {
        'source': 'node_modules/diva.js/build/**',
        'dest': 'asset/vendor/diva',
    },
];

gulp.task('clean', function(done) {
    bundle.forEach(function (module) {
        return del.sync(module.dest);
    });
    done();
});

gulp.task('sync', function (done) {
    bundle.forEach(function (module) {
        gulp.src(module.source)
            .pipe(gulp.dest(module.dest))
            .on('end', done);
    });
});

gulp.task('default', gulp.series('clean', 'sync'));

gulp.task('install', gulp.task('default'));

gulp.task('update', gulp.task('default'));
