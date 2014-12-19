module.exports = function(grunt) {
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		banner: '/*\n<%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %>\n<%= pkg.description %>\nLovingly coded by <%= pkg.author.name %>  - <%= pkg.author.url %> \n*/\n',		
		cssmin: {
			combine: {
				options: {
					banner: '/*\nTheme Name: <%= pkg.name %>\nTheme URI: http://www.<%= pkg.name %>.com\nDescription: \nAuthor: Barrel\nAuthor URI: http://barrelny.com/\nVersion: 1.0\nTags: responsive\n*/\n'
				},
				files: {
					'ss/<%= pkg.name %>.min.css': ['ss/main.css'],
					'ss/<%= pkg.name %>-responsive.min.css': ['ss/responsive.css'],
					'functions/ss/<%= pkg.name %>-admin.min.css': [
						'functions/ss/stats.css', 
						'functions/ss/main.css', 
//						'functions/js/jpicker/css/jPicker-1.1.6.css', 
						'functions/js/jqueryui/css/overcast/jquery-ui-1.8.16.custom.css'
					],
					'premium/ss/<%= pkg.name %>-premium.min.css': ['premium/ss/main.css', 'premium/js/fancybox/jquery.fancybox-1.3.4.css' ]
				}
			}
		},
		concat: {
			options: {
				separator: '',
				stripBanners: {
					block: true,
					line: true
				},
				banner: '<%= banner %>'
			},
			dist: {
				src: ['js/jqModal.js', 'js/spin.js', 'js/jquery.imagesloaded.js', 'js/init.js'],
				dest: 'js/<%= pkg.name %>.js'
			},
			admin: {
				src: [
					'js/jqModal.js', 
					'functions/js/jquerycookie.js', 
					'functions/js/jquery.scrollTo-min.js',
					'functions/js/init.js'],
				dest: 'functions/js/<%= pkg.name %>-admin.js'
			},
			premium: {
				src: [ 'premium/js/jquery.plugin.js', 'premium/js/jquery.countdown.js', 'premium/js/fancybox/jquery.fancybox-1.3.4.js', 'premium/js/init.js' ],
				dest: 'premium/js/<%= pkg.name %>-premium.js'
			}
		},
		uglify: {
			options: {
				banner: '<%= banner %>'
			},
			dist: {
				files: {
					'js/<%= pkg.name %>.min.js': ['<%= concat.dist.dest %>']
				}
			},
			admin: {
				files: {
					'functions/js/<%= pkg.name %>-admin.min.js': ['<%= concat.admin.dest %>']
				}
			},
			premium: {
				files: {
					'premium/js/<%= pkg.name %>-premium.min.js': ['<%= concat.premium.dest %>']
				}
			}
		},
		watch: {
			options: {
				livereload: true
			},
			cssmin: {
				files: ['ss/*.css', 'functions/ss/*.css', 'premium/ss/*.css'],
				tasks: ['cssmin']
			},
			concat: {
				files: ['js/*.js', 'functions/js/*.js', 'premium/js/*.js'],
				tasks: ['concat:dist', 'concat:admin', 'concat:premium']
			},
			uglify: {
				files: ['js/<%= pkg.name %>.js', 'functions/js/<%= pkg.name %>-admin.js', 'premium/js/<%= pkg.name %>-premium.js'],
				tasks: ['uglify:dist', 'uglify:admin', 'uglify:premium']
			},
			php: {
				files: '**/*.php'
			}
		}
	});
	
	grunt.registerTask('build', [
		'cssmin',
		'concat:dist',
		'concat:admin',
		'concat:premium',
		'uglify:dist',
		'uglify:admin',
		'uglify:premium'
	]);
	
	grunt.registerTask('server', [
		'cssmin',
		'concat:dist',
		'concat:admin',
		'concat:premium',
		'uglify:dist',
		'uglify:admin',
		'uglify:premium',
		'watch'
	]);

	grunt.registerTask('default', 'build');
};
