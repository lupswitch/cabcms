module.exports = function(gulp, config, $){

	var ret;
	gulp.task('js', function(){
		for(js in config['jses'])
		{
			ret = gulp.src(config['jses'][js])
			// .pipe($.concat( js + '.js'))
			.pipe($.uglify())
			.pipe($.rev())
			.pipe($.filename({ bundleName: js }))
			.pipe(gulp.dest(config.staticdir + 'js/'))
		}

		return ret;
	});
}