var gulp = require('gulp');
var concat = require('gulp-concat');
var minifyCSS = require('gulp-minify-css');
var autoprefixer = require('gulp-autoprefixer');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');





gulp.task('css', function() {
    gulp.src('assets/limitless/css/**/*.css')
        .pipe(minifyCSS())
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9'))
        .pipe(concat('limitless.min.css'))
        .pipe(gulp.dest('assets/styles'))
});


gulp.task('scripts', function() {
    gulp.src(['assets/limitless/js/plugins/loaders/pace.min.js',
            'assets/limitless/js/core/libraries/jquery.min.js',
            'assets/limitless/js/core/libraries/bootstrap.min.js',
            'assets/limitless/js/plugins/loaders/blockui.min.js',
            'assets/limitless/js/plugins/visualization/d3/d3.min.js',
            'assets/limitless/js/plugins/visualization/d3/d3_tooltip.js',
            'assets/limitless/js/plugins/forms/styling/switchery.min.js',
            'assets/limitless/js/plugins/forms/styling/uniform.min.js',
            'assets/limitless/js/plugins/forms/selects/bootstrap_multiselect.js',
            'assets/limitless/js/plugins/ui/moment/moment.min.js',
            'assets/limitless/js/plugins/pickers/daterangepicker.js',
            'assets/limitless/js/plugins/ui/nicescroll.min.js',
            'assets/limitless/js/core/app.js',
            'assets/limitless/js/plugins/ui/ripple.min.js',
            'assets/limitless/js/plugins/tables/datatables/datatables.min.js',
            'assets/limitless/js/pages/datatables_basic.js',
            'assets/limitless/js/pages/mail_list.js',
            'assets/limitless/js/plugins/forms/selects/bootstrap_select.min.js'
        ])
        .pipe(concat('limitless.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('assets/scripts'))
});