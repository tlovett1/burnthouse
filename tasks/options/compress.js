module.exports = {
	main: {
		options: {
			mode: 'zip',
			archive: './release/bh.<%= pkg.version %>.zip'
		},
		expand: true,
		cwd: 'release/<%= pkg.version %>/',
		src: ['**/*'],
		dest: 'bh/'
	}
};