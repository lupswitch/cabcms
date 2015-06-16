module.exports = function(){
	var bower_path ='bower_components/';
	var buildcssdir = 'assets/dist/css/';
	var staticdir = 'public/static/';
	var htmldir = 'html';

	var config = {};

	config['sassfiles'] = 'assets/sass/**/*.scss';
	config['buildcssdir'] = buildcssdir;
	config['staticdir'] = staticdir;
	config['htmldir'] = htmldir;


	config['csses'] = {
		libs: [
			bower_path + 'bootstrap/dist/css/bootstrap.min.css',
			bower_path + 'bootstrap/dist/css/bootstrap.css',
		],
		user: [
			buildcssdir + '**/*.css'
		]
	};

	config['jses'] = {
		libs: [
			bower_path + 'angular/angular.min.js'
		]
	}

	return config;
}