
const pkg = require('../package')
const currentYear = new Date().getFullYear()

/**
 * Build header
 * @returns {string}
 */
function createHeader() {

    return ['/**',
        ` * Wordpress plugin : Social Links Icons v${pkg.version}`,
        ` * Copyright ${currentYear} ${pkg.author}`,
        ` * Licensed under ${pkg.license}`,
        ' */',
        ''].join('\n')
}
module.exports = createHeader();