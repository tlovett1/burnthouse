module.exports = {
	dist: {
		options: {
			processors: [
				require('autoprefixer')({browsers: 'last 2 versions'})
			]
		},
		files: { 
			'assets/css/burnthouse-theme.css': [ 'assets/css/burnthouse-theme.css' ]
		}
	}
};