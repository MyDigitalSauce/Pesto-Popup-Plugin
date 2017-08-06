module.exports = function( grunt ) {

	// we need to concatenate the files in a specific order so that the app doesnt break
	var defaults = {
		css: ['includes/src/css/modal-only-bootstrap.css',
		      'includes/src/css/plugin-style.css'],
		js: ['includes/src/js/modal-only-bootstrap.js',
		      'includes/src/js/plugin-scripts.js']
	};

	grunt.initConfig({

		pkg: grunt.file.readJSON( 'package.json' ),

		concat: {
			options: {
				separator: ';'
			},
			dist: {
				src: [ defaults.js ],
				dest: 'includes/dist/js/bundle-scripts.js'
			}
		},
		uglify: {
			dist: {
				files: {
					// 'dist/js/bundle.min.js' : 'dist/js/bundle.js'
					// or
					'includes/dist/js/bundle-scripts.min.js' : '<%= concat.dist.dest %>'
				}
			}
		},
		jshint: {
			// the concat.dist.src is not an array and instead a list
			files: [ 'gruntfile.js', '<%= concat.dist.src %>' ],
			option: {
				globals: {
					console: true,
					module: true
				}
			}
		}

	});

	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	// jshint is producing too many javascript erros to be in default build
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );

	grunt.registerTask( 'default', [ 'concat', 'uglify' ] );

};
