<?php
/*
 * Plugin Name:       Easy Videos
 * Plugin URI:        http://example.com/easy-videos-uri/
 * Description:       This is a test project by wildmedia.
 * Version:           1.0.0
 * Author:            Irshad Ahmad Khan
 * Author URI:        https://www.upwork.com/fl/irshadahmad
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       easy-videos
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'EASY_VIDEOS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-easy-videos-activator.php
 */
function activate_easy_videos() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-easy-videos-activator.php';
	Easy_Videos_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-easy-videos-deactivator.php
 */
function deactivate_easy_videos() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-easy-videos-deactivator.php';
	Easy_Videos_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_easy_videos' );
register_deactivation_hook( __FILE__, 'deactivate_easy_videos' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-easy-videos.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_easy_videos() {

	$plugin = new Easy_Videos();
	$plugin->run();

}
run_easy_videos();
