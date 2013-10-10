var _ = require('underscore');

module.exports = function (grunt) {
    "use strict";

    var STWebSiteBundle;

    STWebSiteBundle = {
        'js':   ['src/ST/WebSiteBundle/Resources/public/**/*.js', '!src/ST/WebSiteBundle/Resources/public/vendor/**/*.js', 'Gruntfile.js'],
        'scss': ['src/ST/WebSiteBundle/Resources/public/scss/**/*.scss'],
        'twig': ['src/ST/WebSiteBundle/Resources/views/**/*.html.twig'],
        'img':  ['src/ST/WebSiteBundle/Resources/public/img/**/*.{png,jpg,jpeg,gif,webp}'],
        'svg':  ['src/ST/WebSiteBundle/Resources/public/img/**/*.svg']
    };

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        watch: {
            STWebSiteBundleJs: {
                files: STWebSiteBundle.js,
                tasks: 'jshint:STWebSiteBundle',
                options: {
                    nospawn: true
                }
            },
            STWebSiteBundleScss: {
                files: STWebSiteBundle.scss,
                tasks: 'sass'
            },
            STWebSiteBundleImages: {
                files: STWebSiteBundle.img,
                tasks: ['imagemin:STWebSiteBundle'],
                options: {
                    event: ['added', 'changed']
                }
            },
            STWebSiteBundleSvg: {
                files: STWebSiteBundle.svg,
                tasks: ['svg2png:STWebSiteBundle'],
                options: {
                    event: ['added', 'changed']
                }
            },
            livereload: {
                files: [STWebSiteBundle.js, STWebSiteBundle.twig, STWebSiteBundle.img, STWebSiteBundle.svg, 'web/frontend/style.css'],
                options: {
                    livereload: true
                }
            }
        },

        sass: {
            dist: {
                files: {
                    'web/frontend/style.css': 'src/ST/WebSiteBundle/Resources/public/scss/style.scss',
                    'web/frontend/ie8.css': 'src/ST/WebSiteBundle/Resources/public/scss/legacy/ie/ie8.scss',
                    'web/frontend/ie7.css': 'src/ST/WebSiteBundle/Resources/public/scss/legacy/ie/ie7.scss'
                }
            }
        },

        jshint: {
            options: {
                camelcase: true,
                curly: true,
                eqeqeq: true,
                eqnull: true,
                forin: true,
                indent: 4,
                trailing: true,
                undef: true,
                browser: true,
                devel: true,
                node: true,
                globals: {
                    jQuery: true,
                    $: true
                }
            },
            STWebSiteBundle: {
                files: {
                    src: STWebSiteBundle.js
                }
            }
        },

        imagemin: {
            STWebSiteBundle: {
                options: {
                    optimizationLevel: 3,
                    progressive: true
                },
                files: [{
                    expand: true,
                    cwd: 'src/ST/WebSiteBundle/Resources/public/img',
                    src: '**/*.{png,jpg,jpeg,gif,webp}',
                    dest: 'src/ST/WebSiteBundle/Resources/public/img'
                }]
            }
        },

        svg2png: {
            STWebSiteBundle: {
                files: [{
                    src: STWebSiteBundle.svg
                }]
            }
        },

        modernizr: {
            STWebSiteBundle: {
                files: {
                    dev: "remote",
                    src: _.union(STWebSiteBundle.js, STWebSiteBundle.scss, STWebSiteBundle.twig),
                    dest: "src/ST/WebSiteBundle/Resources/public/vendor/modernizr/modernizr-custom.js"
                },
                parseFiles: true,
                extra: {
                    "shiv" : true,
                    "printshiv" : false,
                    "load" : true,
                    "mq" : false,
                    "cssclasses" : true
                },
                extensibility: {
                    "addtest" : false,
                    "prefixed" : false,
                    "teststyles" : false,
                    "testprops" : false,
                    "testallprops" : false,
                    "hasevents" : false,
                    "prefixes" : false,
                    "domprefixes" : false
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-svg2png');
    grunt.loadNpmTasks("grunt-modernizr");
    grunt.loadNpmTasks('grunt-notify');

    grunt.registerTask('default', ['watch']);
    grunt.registerTask('build', ['modernizr', 'sass']);
};
