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
 * @package           Mymetabox
 *
 * @wordpress-plugin
 * Plugin Name:       mymetabox
 * Plugin URI:        https://makewebbetter.com/product/mymetabox/
 * Description:       Your Basic Plugin
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       mymetabox
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
function define_mymetabox_constants() {

	mymetabox_constants( 'MYMETABOX_VERSION', '1.0.0' );
	mymetabox_constants( 'MYMETABOX_DIR_PATH', plugin_dir_path( __FILE__ ) );
	mymetabox_constants( 'MYMETABOX_DIR_URL', plugin_dir_url( __FILE__ ) );
	mymetabox_constants( 'MYMETABOX_SERVER_URL', 'https://makewebbetter.com' );
	mymetabox_constants( 'MYMETABOX_ITEM_REFERENCE', 'mymetabox' );
}


/**
 * Callable function for defining plugin constants.
 *
 * @param   String $key    Key for contant.
 * @param   String $value   value for contant.
 * @since             1.0.0
 */
function mymetabox_constants( $key, $value ) {

	if ( ! defined( $key ) ) {

		define( $key, $value );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mymetabox-activator.php
 */
function activate_mymetabox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mymetabox-activator.php';
	Mymetabox_Activator::mymetabox_activate();
	$mwb_m_active_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_m_active_plugin ) && ! empty( $mwb_m_active_plugin ) ) {
		$mwb_m_active_plugin['mymetabox'] = array(
			'plugin_name' => __( 'mymetabox', 'mymetabox' ),
			'active' => '1',
		);
	} else {
		$mwb_m_active_plugin = array();
		$mwb_m_active_plugin['mymetabox'] = array(
			'plugin_name' => __( 'mymetabox', 'mymetabox' ),
			'active' => '1',
		);
	}
	update_option( 'mwb_all_plugins_active', $mwb_m_active_plugin );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mymetabox-deactivator.php
 */
function deactivate_mymetabox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mymetabox-deactivator.php';
	Mymetabox_Deactivator::mymetabox_deactivate();
	$mwb_m_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_m_deactive_plugin ) && ! empty( $mwb_m_deactive_plugin ) ) {
		foreach ( $mwb_m_deactive_plugin as $mwb_m_deactive_key => $mwb_m_deactive ) {
			if ( 'mymetabox' === $mwb_m_deactive_key ) {
				$mwb_m_deactive_plugin[ $mwb_m_deactive_key ]['active'] = '0';
			}
		}
	}
	update_option( 'mwb_all_plugins_active', $mwb_m_deactive_plugin );
}

register_activation_hook( __FILE__, 'activate_mymetabox' );
register_deactivation_hook( __FILE__, 'deactivate_mymetabox' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mymetabox.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mymetabox() {
	define_mymetabox_constants();

	$m_plugin_standard = new Mymetabox();
	$m_plugin_standard->m_run();
	$GLOBALS['m_mwb_m_obj'] = $m_plugin_standard;

}
run_mymetabox();

// Add rest api endpoint for plugin.
add_action( 'rest_api_init', 'm_add_default_endpoint' );

/**
 * Callback function for endpoints.
 *
 * @since    1.0.0
 */
function m_add_default_endpoint() {
	register_rest_route(
		'm-route',
		'/m-dummy-data/',
		array(
			'methods'  => 'POST',
			'callback' => 'mwb_m_default_callback',
			'permission_callback' => 'mwb_m_default_permission_check',
		)
	);
}

/**
 * API validation
 * @param 	Array 	$request 	All information related with the api request containing in this array.
 * @since    1.0.0
 */
function mwb_m_default_permission_check($request) {

	// Add rest api validation for each request.
	$result = true;
	return $result;
}

/**
 * Begins execution of api endpoint.
 *
 * @param   Array $request    All information related with the api request containing in this array.
 * @return  Array   $mwb_m_response   return rest response to server from where the endpoint hits.
 * @since    1.0.0
 */
function mwb_m_default_callback( $request ) {
	require_once MYMETABOX_DIR_PATH . 'includes/class-mymetabox-api-process.php';
	$mwb_m_api_obj = new Mymetabox_Api_Process();
	$mwb_m_resultsdata = $mwb_m_api_obj->mwb_m_default_process( $request );
	if ( is_array( $mwb_m_resultsdata ) && isset( $mwb_m_resultsdata['status'] ) && 200 == $mwb_m_resultsdata['status'] ) {
		unset( $mwb_m_resultsdata['status'] );
		$mwb_m_response = new WP_REST_Response( $mwb_m_resultsdata, 200 );
	} else {
		$mwb_m_response = new WP_Error( $mwb_m_resultsdata );
	}
	return $mwb_m_response;
}


// Add settings link on plugin page.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mymetabox_settings_link' );

/**
 * Settings link.
 *
 * @since    1.0.0
 * @param   Array $links    Settings link array.
 */
function mymetabox_settings_link( $links ) {

	$my_link = array(
		'<a href="' . admin_url( 'admin.php?page=mymetabox_menu' ) . '">' . __( 'Settings', 'mymetabox' ) . '</a>',
	);
	return array_merge( $my_link, $links );
}
//MY META BOX
function replace_metacontent( $text ) {
	global $post;
	//print_r($post->ID);
	$metapost=get_post_meta($post->ID, '_replace_mymeta');
	$select=$metapost[0][0];
	$from= $metapost[0][1];
	$to=$metapost[0][2];
	   if($select=='exact') {
		   $var=str_replace($from.'',$to,$text);
		   return $var;
	   }	
	   elseif($select=='contains') {
		   $var=str_replace($from,$to,$text);
		   return $var;
	   }	
   }
   add_filter( 'the_content', 'replace_metacontent');

function replace_add_custom_box() {
    $screens = [ 'post', 'replace_cpt' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'replace_box_id',                 // Unique ID
            'Replace Content',      // Box title
            'replace_custom_box_html',  // Content callback, must be of type callable
            $screen                            // Post type
        );
    }
}
add_action( 'add_meta_boxes', 'replace_add_custom_box' );

function replace_custom_box_html( $post ) {
    $value= get_post_meta( $post->ID, '_replace_meta_from', true );
    //print_r($value);
    ?>
    <div class="postbox p-2">
        <label for="replace-from"><b>From</b></label>
        <input type="text" id="replace-from" name="replace-from" value="<?php echo esc_attr( get_post_meta( $post->ID, 'replace-from', true ) ); ?>" >
    </div>
    <!--- to field-->
	<?php
	$value= get_post_meta( $post->ID, '_replace_meta_to', true );
	?>
    <div class="postbox p-2">
        <label for="replace-to"><b>To</b></label>
        <input type="text" id="replace-to" name="replace-to" value="<?php echo esc_attr( get_post_meta( $post->ID, 'replace-to', true ) ); ?>" >
    </div>
    <!--- select field-->
	<?php
	$value= get_post_meta( $post->ID, '_replace_meta_select', true );
	?>
    <div class="postbox p-2">
    <label for="replace-select"><b>Select</b></label>
    <select name="replace-select" id="replace-select" >
        <option value="">Select something...</option>
        <option value="exact" <?php selected( $value, 'exact' ); ?>>Exact</option>
        <option value="contains" <?php selected( $value, 'contains' ); ?>>Contains</option>
    </select>
    </div>
    <?php
}

function replace_save_postdata( $post_id ) {
	$arr=array($_POST['replace-select'], $_POST['replace-from'], $_POST['replace-to']);
    if ( array_key_exists( 'replace-select', $_POST ) && array_key_exists( 'replace-from', $_POST ) && array_key_exists( 'replace-to', $_POST )) {
        update_post_meta(
            $post_id,
            '_replace_mymeta',
            $arr
        );
    }
}
add_action( 'save_post', 'replace_save_postdata' );

