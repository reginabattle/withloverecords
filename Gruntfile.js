module.exports = function(grunt) {

    // Configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // Concatinate files
        concat: {
            dist: {
                src: [
                    'js/libs/*.js', 
                ],
                dest: 'js/scripts.js',
            }
        },

        // Minify files
        uglify: {
            build: {
                src: 'js/scripts.js',
                dest: 'js/scripts.min.js'
            }
        },
                                                                                                                                                                                                                                                            
        // Compile SASS (with Compass)
        compass: {
            dist: {
                options: {
                    sassDir: 'sass',
                    cssDir: 'css',
                    outputStyle: 'compressed',
                }
            }
        },


        // Watch files
        watch: {
            scripts: {
                files: ['js/*.js'],
                tasks: ['concat', 'uglify'],
                options: {
                    spawn: false,
                },
            }, 

            css: {
                files: ['**/*.scss'],
                tasks: ['compass']
            }
        },


    });

    // Tell Grunt what plugin(s) to use
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Tell Grunt what to do when ("grunt" command)
    grunt.registerTask('default', ['concat', 'uglify', 'watch',]);

};