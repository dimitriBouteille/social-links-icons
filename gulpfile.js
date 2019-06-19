const gulp = require("gulp")
const sass = require("gulp-sass")
const postcss = require("gulp-postcss")
const autoprefixer = require("autoprefixer")
const cleanCSS = require('gulp-clean-css')
const headerFile = require('./tools/header.js')
const header = require('gulp-header')
const uglify = require('gulp-uglify-es').default

/**
 * Root folder where Css and Js files are saved
 * @type {string}
 */
const globalDistDir = 'dist'

/**
 * @type {{jsMinGlobal: string[], cssOutput: string, jsOutput: string, scssDir: string, cssMinGlobal: string[], jsGlobal: string[], cssGlobal: string[], jsDir: string}}
 */
const config = {
    scssDir :       'src/scss/**/*.scss',
    cssOutput :     `${globalDistDir}/css`,
    cssGlobal :     [`${globalDistDir}/css/**/*.css`, `!${globalDistDir}/css/vendor/**/*.css`],
    cssMinGlobal :  [`${globalDistDir}/css/**/*.min.css`, `!${globalDistDir}/css/vendor/**/*.min.css`],
    jsDir :         'src/js/**/*.js',
    jsOutput:       `${globalDistDir}/js`,
    jsGlobal :      [`${globalDistDir}/js/**/*.js`,`!${globalDistDir}/js/vendor/**/*.js`],
    jsMinGlobal:    [`${globalDistDir}/js/**/*.min.js`, `!${globalDistDir}/js/vendor/**/*.min.js`]
}

/**
 * Ajoute le header aux fichiers se trouvant dans path
 * @param path
 * @param output
 * @returns {*}
 */
function addHeader(path, output) {
    return gulp
        .src(path)
        .pipe(header(headerFile))
        .pipe(gulp.dest(output))
}

/**
 * Watch les fichiers Scss et js
 */
function watch() {

    gulp.watch(config.scssDir, compileSass)
    gulp.watch(config.jsDir, compileJs)
}

/**
 * Compile les fichiers Scss
 * @returns {*}
 */
function compileSass() {

    return gulp
        .src(config.scssDir)
        .pipe(sass({
            outputStyle: 'expanded'
        }).on('error', sass.logError))
        .pipe(postcss([autoprefixer({
            cascade: false
        })]))
        .pipe(cleanCSS())
        .pipe(gulp.dest(config.cssOutput))
}
function addHeaderCssFiles() {
    return addHeader(config.cssGlobal, config.cssOutput)
}

/**
 * Deplace les fichiers js en developpement vers le dossier de production
 * @returns {*}
 */
function compileJs() {

    return gulp
        .src(config.jsDir)
        .pipe(uglify())
        .pipe(gulp.dest(config.jsOutput))
}
function addHeaderJsFiles() {
    return addHeader(config.jsGlobal, config.jsOutput)
}

module.exports = {
    watch,
    compileSass,
    compileJs,
    minifyCss :
        gulp.series(compileSass, addHeaderCssFiles),
    minifyJs:
        gulp.series(compileJs, addHeaderJsFiles),
    default:
        gulp.parallel(
            gulp.series(compileSass, addHeaderCssFiles),
            gulp.series(compileJs, addHeaderJsFiles)
        )
}