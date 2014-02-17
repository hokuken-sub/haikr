module.exports = function(grunt){
  var pkg = grunt.file.readJSON('package.json');

  var lessConfig = {
      development: {
        options: {
          compress: true
        },
        files: [
          {
            src: ['./app/assets/stylesheets/haik.less'],
            dest: './public/assets/stylesheets/haik.css',
          },
          {
            src: [
              './app/assets/stylesheets/haik-admin.less',
              './app/lib/Toiee/haik/Plugins/**/helper/assets/stylesheets/helper.less'
            ],
            dest: './public/assets/stylesheets/haik-admin.css',
          }
        ]
      }
  };

  grunt.initConfig({
    less: lessConfig,
    concat: {
      options: {
        separator: ';'
      },
      js_haik: {
        src: ['./app/assets/javascript/*.js', './app/lib/Toiee/haik/Plugins/**/public/javascript/*.js'],
        dest: './public/assets/javascript/haik.js'
      },
      js_haik_admin: {
        src: ['./app/assets/javascript/admin/*.js', './app/lib/Toiee/haik/Plugins/**/helper/assets/javascript/*.js'],
        dest: './public/assets/javascript/haik-admin.js'
      }
    },
    uglify: {
      options: {
        mangle: false
      },
      haik: {
        files: {
          './public/assets/javascript/haik.js': './public/assets/javascript/haik.js'
        }
      },
      haik_admin: {
        files: {
          './public/assets/javascript/haik-admin.js': './public/assets/javascript/haik-admin.js'
        }
      },
    },
	watch: {
      js_haik: {
        files: [
          './app/assets/javascript/*.js',
          './app/lib/Toiee/haik/Plugins/**/public/javascript/*.js',
          './app/assets/stylesheets/*',
          './app/lib/Toiee/haik/Plugins/**/public/stylesheets/*'
        ],
        tasks: ['concat:js_haik']
      },
      js_haik_admin: {
        files: [
          './app/assets/javascript/admin/*.js',
          './app/lib/Toiee/haik/Plugins/**/helper/assets/javascript/*.js'
        ],
        tasks: ['concat:js_haik_admin']
      },
      less: {
        files: [
          './app/assets/stylesheets/*.less',
          './app/assets/stylesheets/admin/*',
          './app/lib/Toiee/haik/Plugins/**/helper/assets/stylesheets/*'
        ],
        tasks: ['less'],
        options: {
          liveoverload: true
        }
      },
    }
  });

　var taskName;
  for (taskName in pkg.devDependencies) {
    if (taskName.substring(0, 6) == 'grunt-') {
      grunt.loadNpmTasks(taskName);
    }
  }
  
  grunt.registerTask('default', ['watch']);
};