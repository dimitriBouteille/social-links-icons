<?php

/**
 * Plugin Name:     Social Links Icons
 * Description:     Simply set up links and icons to your social networks.
 * Version:         1.0.0
 * Author:          Dimitri BOUTEILLE
 * Author URI:      https://dimitri-bouteille.fr/
 * Text Domain:     social-links-icons
 * License:         GPL2
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package SocialLinksIcons
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'SLI_DIR' ) ) {
    define( 'SLI_DIR', __DIR__ );
}

if(!class_exists('SocialLinksIcons')) {
    include_once SLI_DIR.'/includes/SLI_Loader.php';
}

/**
 * Function SLI
 *
 * @return SLI_Loader|null
 * @throws ReflectionException
 * @throws SLI_Exception
 */
function SLI() {

    return SLI_Loader::instance();
}

add_action('init', 'SLI');