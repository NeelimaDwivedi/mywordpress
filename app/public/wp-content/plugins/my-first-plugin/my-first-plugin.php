<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           My_First_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       my first plugin
 * Plugin URI:        https://makewebbetter.com/product/my-first-plugin/
 * Description:       Your Basic Plugin
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       my-first-plugin
 * Domain Path:       /languages
 *
 * Requires at least: 4.6
 * Tested up to:      4.9.5
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Define plugin constants.
 *
 * @since             1.0.0
 */
function define_my_first_plugin_constants() {

	my_first_plugin_constants( 'MY_FIRST_PLUGIN_VERSION', '1.0.0' );
	my_first_plugin_constants( 'MY_FIRST_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
	my_first_plugin_constants( 'MY_FIRST_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
	my_first_plugin_constants( 'MY_FIRST_PLUGIN_SERVER_URL', 'https://makewebbetter.com' );
	my_first_plugin_constants( 'MY_FIRST_PLUGIN_ITEM_REFERENCE', 'my first plugin' );
}


/**
 * Callable function for defining plugin constants.
 *
 * @param   String $key    Key for contant.
 * @param   String $value   value for contant.
 * @since             1.0.0
 */
function my_first_plugin_constants( $key, $value ) {

	if ( ! defined( $key ) ) {

		define( $key, $value );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-my-first-plugin-activator.php
 */
function activate_my_first_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-my-first-plugin-activator.php';
	My_First_Plugin_Activator::my_first_plugin_activate();
	$mwb_mfp_active_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_mfp_active_plugin ) && ! empty( $mwb_mfp_active_plugin ) ) {
		$mwb_mfp_active_plugin['my-first-plugin'] = array(
			'plugin_name' => __( 'my first plugin', 'my-first-plugin' ),
			'active' => '1',
		);
	} else {
		$mwb_mfp_active_plugin = array();
		$mwb_mfp_active_plugin['my-first-plugin'] = array(
			'plugin_name' => __( 'my first plugin', 'my-first-plugin' ),
			'active' => '1',
		);
	}
	update_option( 'mwb_all_plugins_active', $mwb_mfp_active_plugin );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-my-first-plugin-deactivator.php
 */
function deactivate_my_first_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-my-first-plugin-deactivator.php';
	My_First_Plugin_Deactivator::my_first_plugin_deactivate();
	$mwb_mfp_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_mfp_deactive_plugin ) && ! empty( $mwb_mfp_deactive_plugin ) ) {
		foreach ( $mwb_mfp_deactive_plugin as $mwb_mfp_deactive_key => $mwb_mfp_deactive ) {
			if ( 'my-first-plugin' === $mwb_mfp_deactive_key ) {
				$mwb_mfp_deactive_plugin[ $mwb_mfp_deactive_key ]['active'] = '0';
			}
		}
	}
	update_option( 'mwb_all_plugins_active', $mwb_mfp_deactive_plugin );
}

register_activation_hook( __FILE__, 'activate_my_first_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_my_first_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-my-first-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_my_first_plugin() {
	define_my_first_plugin_constants();

	$mfp_plugin_standard = new My_First_Plugin();
	$mfp_plugin_standard->mfp_run();
	$GLOBALS['mfp_mwb_mfp_obj'] = $mfp_plugin_standard;

}
run_my_first_plugin();

// Add rest api endpoint for plugin.
add_action( 'rest_api_init', 'mfp_add_default_endpoint' );

/**
 * Callback function for endpoints.
 *
 * @since    1.0.0
 */
function mfp_add_default_endpoint() {
	register_rest_route(
		'mfp-route',
		'/mfp-dummy-data/',
		array(
			'methods'  => 'POST',
			'callback' => 'mwb_mfp_default_callback',
			'permission_callback' => 'mwb_mfp_default_permission_check',
		)
	);
}

/**
 * API validation
 * @param 	Array 	$request 	All information related with the api request containing in this array.
 * @since    1.0.0
 */
function mwb_mfp_default_permission_check($request) {

	// Add rest api validation for each request.
	$result = true;
	return $result;
}

/**
 * Begins execution of api endpoint.
 *
 * @param   Array $request    All information related with the api request containing in this array.
 * @return  Array   $mwb_mfp_response   return rest response to server from where the endpoint hits.
 * @since    1.0.0
 */
function mwb_mfp_default_callback( $request ) {
	require_once MY_FIRST_PLUGIN_DIR_PATH . 'includes/class-my-first-plugin-api-process.php';
	$mwb_mfp_api_obj = new My_First_Plugin_Api_Process();
	$mwb_mfp_resultsdata = $mwb_mfp_api_obj->mwb_mfp_default_process( $request );
	if ( is_array( $mwb_mfp_resultsdata ) && isset( $mwb_mfp_resultsdata['status'] ) && 200 == $mwb_mfp_resultsdata['status'] ) {
		unset( $mwb_mfp_resultsdata['status'] );
		$mwb_mfp_response = new WP_REST_Response( $mwb_mfp_resultsdata, 200 );
	} else {
		$mwb_mfp_response = new WP_Error( $mwb_mfp_resultsdata );
	}
	return $mwb_mfp_response;
}


// Add settings link on plugin page.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'my_first_plugin_settings_link' );

/**
 * Settings link.
 *
 * @since    1.0.0
 * @param   Array $links    Settings link array.
 */
function my_first_plugin_settings_link( $links ) {

	$my_link = array(
		'<a href="' . admin_url( 'admin.php?page=my_first_plugin_menu' ) . '">' . __( 'Settings', 'my-first-plugin' ) . '</a>',
	);
	return array_merge( $my_link, $links );
}

//add_action('init', 'show_hello');

// function show_hello(){
// 	$var='Hello World';
// 	echo $var;
// }

add_filter('my_filt', 'show_bye'); 
function show_bye($var) {
	$var="bye world";
	return $var;
}

add_filter( 'the_content', 'filter_the_content_in_the_main_loop', 1 );
function filter_the_content_in_the_main_loop( $content ) {
	if ( is_singular() && in_the_loop() && is_main_query() ) {
		return str_replace("hi","bye",$content);
	}
}

add_filter('the_title', 'wpshout_filter_example');
function wpshout_filter_example($title) {
	return str_replace("demo","bye",$title);
}

