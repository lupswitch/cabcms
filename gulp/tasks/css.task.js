module.exports = function(gulp, config, $){

	gulp.task('css', function(){
		var ret = gulp.src(config.sassfiles)
			.pipe($.sass())
			.pipe($.autoprefixer('last 10 version'))
			.pipe(gulp.dest(config.buildcssdir));

		// $.del(['static/styles-*.css'], function(err){});

		var ret;
		for(css in config['csses'])
		{
			ret = gulp.src(config['csses'][css])
				// .pipe($.concat( css + '.css'))
				.pipe($.rev())
			 	.pipe($.filename({ bundleName: css }))
			 	.pipe($.minifycss())
			 	.pipe(gulp.dest(config.staticdir + 'css/'));
		}

		return ret;
	});

}