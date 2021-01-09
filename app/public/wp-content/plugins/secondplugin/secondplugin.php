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
 * @package           Secondplugin
 *
 * @wordpress-plugin
 * Plugin Name:       secondplugin
 * Plugin URI:        https://makewebbetter.com/product/secondplugin/
 * Description:       Your Basic Plugin
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       secondplugin
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
function define_secondplugin_constants() {

	secondplugin_constants( 'SECONDPLUGIN_VERSION', '1.0.0' );
	secondplugin_constants( 'SECONDPLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
	secondplugin_constants( 'SECONDPLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
	secondplugin_constants( 'SECONDPLUGIN_SERVER_URL', 'https://makewebbetter.com' );
	secondplugin_constants( 'SECONDPLUGIN_ITEM_REFERENCE', 'secondplugin' );
}


/**
 * Callable function for defining plugin constants.
 *
 * @param   String $key    Key for contant.
 * @param   String $value   value for contant.
 * @since             1.0.0
 */
function secondplugin_constants( $key, $value ) {

	if ( ! defined( $key ) ) {

		define( $key, $value );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-secondplugin-activator.php
 */
function activate_secondplugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-secondplugin-activator.php';
	Secondplugin_Activator::secondplugin_activate();
	$mwb_s_active_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_s_active_plugin ) && ! empty( $mwb_s_active_plugin ) ) {
		$mwb_s_active_plugin['secondplugin'] = array(
			'plugin_name' => __( 'secondplugin', 'secondplugin' ),
			'active' => '1',
		);
	} else {
		$mwb_s_active_plugin = array();
		$mwb_s_active_plugin['secondplugin'] = array(
			'plugin_name' => __( 'secondplugin', 'secondplugin' ),
			'active' => '1',
		);
	}
	update_option( 'mwb_all_plugins_active', $mwb_s_active_plugin );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-secondplugin-deactivator.php
 */
function deactivate_secondplugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-secondplugin-deactivator.php';
	Secondplugin_Deactivator::secondplugin_deactivate();
	$mwb_s_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_s_deactive_plugin ) && ! empty( $mwb_s_deactive_plugin ) ) {
		foreach ( $mwb_s_deactive_plugin as $mwb_s_deactive_key => $mwb_s_deactive ) {
			if ( 'secondplugin' === $mwb_s_deactive_key ) {
				$mwb_s_deactive_plugin[ $mwb_s_deactive_key ]['active'] = '0';
			}
		}
	}
	update_option( 'mwb_all_plugins_active', $mwb_s_deactive_plugin );
}

register_activation_hook( __FILE__, 'activate_secondplugin' );
register_deactivation_hook( __FILE__, 'deactivate_secondplugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-secondplugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_secondplugin() {
	define_secondplugin_constants();

	$s_plugin_standard = new Secondplugin();
	$s_plugin_standard->s_run();
	$GLOBALS['s_mwb_s_obj'] = $s_plugin_standard;

}
run_secondplugin();

// Add rest api endpoint for plugin.
add_action( 'rest_api_init', 's_add_default_endpoint' );

/**
 * Callback function for endpoints.
 *
 * @since    1.0.0
 */
function s_add_default_endpoint() {
	register_rest_route(
		's-route',
		'/s-dummy-data/',
		array(
			'methods'  => 'POST',
			'callback' => 'mwb_s_default_callback',
			'permission_callback' => 'mwb_s_default_permission_check',
		)
	);
}

/**
 * API validation
 * @param 	Array 	$request 	All information related with the api request containing in this array.
 * @since    1.0.0
 */
function mwb_s_default_permission_check($request) {

	// Add rest api validation for each request.
	$result = true;
	return $result;
}

/**
 * Begins execution of api endpoint.
 *
 * @param   Array $request    All information related with the api request containing in this array.
 * @return  Array   $mwb_s_response   return rest response to server from where the endpoint hits.
 * @since    1.0.0
 */
function mwb_s_default_callback( $request ) {
	require_once SECONDPLUGIN_DIR_PATH . 'includes/class-secondplugin-api-process.php';
	$mwb_s_api_obj = new Secondplugin_Api_Process();
	$mwb_s_resultsdata = $mwb_s_api_obj->mwb_s_default_process( $request );
	if ( is_array( $mwb_s_resultsdata ) && isset( $mwb_s_resultsdata['status'] ) && 200 == $mwb_s_resultsdata['status'] ) {
		unset( $mwb_s_resultsdata['status'] );
		$mwb_s_response = new WP_REST_Response( $mwb_s_resultsdata, 200 );
	} else {
		$mwb_s_response = new WP_Error( $mwb_s_resultsdata );
	}
	return $mwb_s_response;
}


// Add settings link on plugin page.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'secondplugin_settings_link' );

/**
 * Settings link.
 *
 * @since    1.0.0
 * @param   Array $links    Settings link array.
 */
function secondplugin_settings_link( $links ) {

	$my_link = array(
		'<a href="' . admin_url( 'admin.php?page=secondplugin_menu' ) . '">' . __( 'Settings', 'secondplugin' ) . '</a>',
	);
	return array_merge( $my_link, $links );
}
//mysetting

add_action( 'admin_menu', 'mysetting_options_page' );
function mysetting_options_page() {
    add_menu_page(
        'Mysetting',
        'My-setting',
        'manage_options',
        'mysetting',
        'mysetting_options_page_html',
        'dashicons-menu-alt3',
         89
    );
}

function mysetting_options_page_html() {
    echo '<b>This is my settings</b>';
}

function mydetails_settings_init() {
    // Register a new setting for "wporg" page.
    register_setting( 'mydetails', 'mydetails_options' );
 
    // Register a new section in the "wporg" page.
    add_settings_section(
        'mydetails_section_developers',
        __( 'This is the Personal details form.', 'mydetails' ), 'mydetails_section_developers_callback',
        'mydetails'
    );
 
    // Register a new field in the "wporg_section_developers" section, inside the "wporg" page.
    add_settings_field(
        'name', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Name', 'mydetails' ),
        'mydetails_name',
        'mydetails',
        'mydetails_section_developers',
        array(
            'label_for'         => 'input1',
            'class'             => 'mydetails_row',
            'mydetails_custom_data' => 'custom',
        )
	);
	add_settings_field(
        'age', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Age', 'mydetails' ),
        'mydetails_age',
        'mydetails',
        'mydetails_section_developers',
        array(
            'label_for'         => 'input2',
            'class'             => 'mydetails_row',
            'mydetails_custom_data' => 'custom',
        )
	);
	add_settings_field(
        'Address', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Address', 'mydetails' ),
        'mydetails_address',
        'mydetails',
        'mydetails_section_developers',
        array(
            'label_for'         => 'input3',
            'class'             => 'mydetails_row',
            'mydetails_custom_data' => 'custom',
        )
    );
}
 
/**
 * Register our wporg_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'mydetails_settings_init' );

function mydetails_section_developers_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'fill your details below', 'mydetails' ); ?></p>
    <?php
}


function mydetails_name( $args ) {
	$options = get_option( 'mydetails_options' );
	?>
    <input type="text" name="mydetails_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id=<?php echo esc_attr( $args['label_for'] ); ?> value="<?php echo esc_attr($options['input1'])?>"/>
	<?php
}

function mydetails_age( $args ) {
	$options = get_option( 'mydetails_options' );
	?>
    <input type="text" name="mydetails_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id=<?php echo esc_attr( $args['label_for'] ); ?> value="<?php echo esc_attr($options['input2'])?>"/>
	<?php
}

function mydetails_address( $args ) {
	$options = get_option( 'mydetails_options' );
	?>
    <input type="text" name="mydetails_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id=<?php echo esc_attr( $args['label_for'] ); ?> value="<?php echo esc_attr($options['input3'])?>"/>
	<?php
   
}

function mydetails_options_page()
{
    add_submenu_page(
        'mysetting',
        'Mydetails',
        'Mydetails',
        'manage_options',
        'mydetails',
        'mydetails_options_page_html'
    );
}
add_action('admin_menu', 'mydetails_options_page');

function mydetails_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
 
    // add error/update messages
 
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'mydetails_messages', 'mydetails_message', __( 'Data Saved', 'mydetails' ), 'updated' );
    }
 
    // show error/update messages
    settings_errors( 'mydetails_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg"
            settings_fields( 'mydetails' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'mydetails' );
            // output save settings button
            submit_button( 'Save Data' );
            ?>
        </form>
    </div>
    <?php
}