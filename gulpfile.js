/**
 * Created by bar on 2/12/16.
 */

var gulp = require('gulp');
var wpPot = require('gulp-wp-pot');
var sort = require('gulp-sort');

gulp.task('pot', function(){
    console.log('creating POT file...');
    return gulp.src('*.php')
        .pipe(sort())
        .pipe(wpPot( {
            domain: 'lm_gd_scoreboard_widget',
            destFile:'languages/template.pot',
            package: 'lm_gd_scoreboard_widget',
            bugReport: 'http://www.brcode.co.il',
            lastTranslator: 'Bar Shai <bar@bar-shai.co.il>',
            team: 'Bar Shai <bar@bar-shai.co.il>'
        } ))
        .pipe(gulp.dest(''));
});

gulp.task('default', ['pot', 'watch'], function() {
    console.log('Default task completed!');
});

gulp.task('watch', function(){
    gulp.watch('*.php', ['pot']);
});
