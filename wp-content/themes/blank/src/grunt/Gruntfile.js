module.exports = function (grunt) {

    require('load-grunt-tasks')(grunt);

    var compass = require('compass-importer');

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        /**
         *
         * Project Settings
         *
         */
        project: {
            name: 'tfbuilding',
            url: 'tfbuilding.dev',
            sass: ['../scss'],
            css: ['../../css'],
            images: ['../../images'],
            js: ['../../js'],
            fonts: ['../fonts'],
            tmp: ['.tmp']
        },

        // Look for CSS files, and JS files and concatenate into single files
        bower_concat: {
            all: {
                dest: '.tmp/js/bower.js',
                cssDest: '.tmp/css/bower.css',
                bowerOptions: {
                    relative: false
                },
                dependencies: {
                    'fancybox': 'jquery'
                },
                mainFiles: {
                    'font-awesome': [
                        'css/font-awesome.css'
                    ]
                },
                exclude: [
                    'susy',
                    'compass-breakpoint',
                    'sassy-maps',
                    'modular-scale',
                    'responsive-modular-scale'
                ]
            }
        },

        // Look for all SCSS files and compile into import maps
        sass_globbing: {
            project: {
                files: {
                    '<%= project.sass %>/_bin_importMap.scss': '<%= project.sass %>/bin/**/*.scss',
                    '<%= project.sass %>/_fct_importMap.scss': '<%= project.sass %>/fct/**/*.scss',
                    '<%= project.sass %>/_modules_importMap.scss': '<%= project.sass %>/modules/**/*.scss',
                    '<%= project.sass %>/_pages_importMap.scss': '<%= project.sass %>/pages/**/*.scss'
                },
                options: {
                    useSingleQuotes: false
                }
            }
        },

        // Compass: Compile SCSS files into CSS
        sass: {
            options: {
                includePaths: [
                    '.compass'
                ],
                importer: compass,
                sourceComments: true,
                noCache: 'true'
            },
            dist: {
                files: {
                    '<%= project.css %>/theme.css': '<%= project.sass %>/theme.scss'
                }
            }
        },

        // Concatenate the CSS and JS files
        concat: {
            js: {
                src: [
                    '<%= project.tmp %>/js/bower.js',
                    '<%= project.js %>/**/*.js',
                    '!<%= project.js %>/<%= project.name %>.js',
                    '!<%= project.js %>/<%= project.name %>.min.js',
                ],
                dest: '<%= project.js %>/<%= project.name %>.js'
            },
            css: {
                src: [
                    '<%= project.css %>/*.css',
                    '<%= project.tmp %>/css/bower.css',
                    '!<%= project.css %>/editor.css',
                    '!<%= project.css %>/<%= project.name %>.css',
                    '!<%= project.css %>/<%= project.name %>.min.css',
                ],
                dest: '<%= project.css %>/<%= project.name %>.css'
            }
        },

        // Minify CSS files
        cssmin: {
            minify: {
                expand: true,
                cwd: '<%= project.css %>/',
                src: [
                    '<%= project.name %>.css'
                ],
                dest: '<%= project.css %>/',
                ext: '.min.css'
            }
        },

        // Minify JS files
        uglify: {
            js: {
                files: {
                    '<%= project.js %>/<%= project.name %>.min.js': '<%= project.js %>/<%= project.name %>.js'
                }
            }
        },

        // Optimise all of the images
        imagemin: {
            options: {
                cache: false
            },
            dist: {
                files: [
                    {
                        expand: true,
                        cwd: '<%= project.images %>/',
                        src: ['**/*.{png,jpg,gif}'],
                        dest: '<%= project.images %>/'
                    }
                ]
            }
        },

        // Create spritesheet
        sprite: {
            all: {
                src: [
                    '<%= project.images %>/*.png',
                    '!<%= project.images %>/spritesheet.png',
                    '!<%= project.images %>/icon_sprite.png',
                    '!<%= project.images %>/icon_sprite@2x.png',
                    '!<%= project.images %>/fancybox_sprite.png',
                    '!<%= project.images %>/fancybox_sprite@2x.png',
                    '!<%= project.images %>/fancybox_loading.gif.png',
                    '!<%= project.images %>/fancybox_loading@2x.gif.png'
                ],
                dest: '<%= project.images %>/spritesheet.png',
                destCss: '<%= project.sass %>/bin/_sprites.scss',
                imgPath: '../images/spritesheet.png'
            }
        },

        // Copy files
        copy: {
            map: {
                src: 'bower_components/jquery-cycle2/build/jquery.cycle2.js.map',
                dest: 'js/jquery.cycle2.js.map'
            },
            devMap: {
                src: 'bower_components/jquery-cycle2/build/jquery.cycle2.js.map',
                dest: '<%= project.tmp %>/js/jquery.cycle2.js.map'
            }
        },

        // Clean up temporary files
        clean: {
            tmp: {
                src: ['<%= project.tmp %>']
            },
            css: {
                src: ['<%= project.tmp %>/css']
            }
        },

        // Sync browser with changes
        browserSync: {
            dev: {
                bsFiles: {
                    src: '<%= project.css %>/theme.css'
                },
                options: {
                    watchTask: true,
                    proxy: "<%= project.url %>"
                }
            }
        },

        // Watch for changes
        watch: {
            options: {
                livereload: true,
                nobeep: true,
                interval: 5007
            },
            config: {
                files: [
                    'Gruntfile.js'
                ]
            },
            js: {
                files: [
                    '<%= project.js %>/**/*.js',
                    '<%= project.tmp %>/js/bower.js',
                    '!<%= project.js %>/bin/inactive/**/*.js',
                    '!<%= project.js %>/<%= project.name %>.js',
                    '!<%= project.js %>/<%= project.name %>.min.js'
                ],
                tasks: [
                    'concat:js',
                    'uglify'
                ]
            },
            php: {
                files: [
                    '../../**/*.php'
                ]
            },
            bower: {
                files: [
                    'bower_components/**/*.css',
                    'bower_components/**/*.js',
                ],
                tasks: [
                    'bower_concat'
                ]
            },
            css: {
                files: [
                    '<%= project.css %>/**/*.css',
                    '!<%= project.css %>/theme.css',
                    '!<%= project.css %>/<%= project.name %>.css',
                    '!<%= project.css %>/<%= project.name %>.min.css'
                ],
                tasks: [
                    'concat:css',
                    'cssmin'
                    //'clean:css'
                ]
            },
            image: {
                files: [
                    '<%= project.images %>/**/*.png',
                    '!<%= project.images %>/spritesheet.png'
                ],
                tasks: [
                    'sprite:all'
                ]
            },
            sass: {
                files: [
                    '<%= project.sass %>/**/*.scss',
                    '../fct/scss/*.scss',
                    '!<%= project.sass %>/*importMap.scss'
                ],
                tasks: [
                    'sass_globbing',
                    'sass',
                    'concat:css',
                    'cssmin'
                ]
            }
        }
    });

    // Grunt Launch task
    grunt.registerTask('launch', [
        'bower_concat',
        'sass_globbing',
        'sass',
        'concat:css',
        'cssmin',
        'concat:js',
        'uglify',
        'sprite:all',
        //'browserSync',
        'watch'
    ]);

    grunt.registerTask('quick-launch', [
        'sass',
        'concat:css',
        'cssmin',
        'watch'
    ]);

    grunt.registerTask('refresh-bower', [
        'bower_concat'
    ]);

    grunt.registerTask('compile-css', [
        'bower_concat',
        'sass_globbing',
        'sass',
        'concat:css',
        'cssmin'
    ]);

    grunt.registerTask('compile-js', [
        'bower_concat',
        'concat:js',
        'uglify'
    ]);

};