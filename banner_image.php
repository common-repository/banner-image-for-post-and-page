<?php
/*
 * Plugin Name:       Banner Image for post and page
 * Plugin URI:        https://wordpress.org/plugins/banner-image-for-post-and-page/
 * Description:       Banner Image is a great plugin to implement custom banner Image for each page. 
   You can set images easily and later can manage CSS from your theme.
 * Tags:              responsive, images, responsive images, disable, srcset
 * Version:           1.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Logicrays
 * Author URI:        http://logicrays.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://wordpress.org/plugins/banner-image-for-post-and-page/
 * Text Domain:       lr-banner-image
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( 'ECPT_LICENSE', true );

if ( ! defined( 'LR_PLUGIN_DIR_PATH' ) ) {
   define( 'LR_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

// Include the core plugin class file
require_once LR_PLUGIN_DIR_PATH . 'includes/class-banner-image.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-banner-image.php
 */
function lr_banner_image_activate() {
    // Add code here to be executed during plugin activation
    // For example: setting default options, creating database tables, etc.
    // Make sure to include checks to avoid any duplicate execution
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-banner-image.php
 */
function lr_banner_image_deactivate() {
    // Add code here to be executed during plugin deactivation
    // For example: cleaning up options, removing custom tables, etc.
}

// Register activation and deactivation hooks
register_activation_hook( __FILE__, 'lr_banner_image_activate' );
register_deactivation_hook( __FILE__, 'lr_banner_image_deactivate' );