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
			return str_ireplace("destroy ","bye",$content);;
}

add_filter('the_content', 'add_content_after');
function add_content_after($content) {
	$count = str_word_count(strip_tags($content));
	$after_content= 'total no. of words:'.$count;
	echo $after_content;
	$fullcontent = $content;
	return $fullcontent;

}
?>
<?php
/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */
 
/**
 * custom option and settings
 */
function wporg_settings_init() {
    // Register a new setting for "wporg" page.
    register_setting( 'wporg', 'wporg_options' );
 
    // Register a new section in the "wporg" page.
    add_settings_section(
        'wporg_section_developers',
        __( 'The Matrix has you.', 'wporg' ), 'wporg_section_developers_callback',
        'wporg'
    );
 
    // Register a new field in the "wporg_section_developers" section, inside the "wporg" page.
    add_settings_field(
        'wporg_field_pill', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Pill', 'wporg' ),
        'wporg_field_pill_cb',
        'wporg',
        'wporg_section_developers',
        array(
            'label_for'         => 'wporg_field_pill',
            'class'             => 'wporg_row',
            'wporg_custom_data' => 'custom',
        )
    );
}
 
/**
 * Register our wporg_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'wporg_settings_init' );
 
 
/**
 * Custom option and settings:
 *  - callback functions
 */
 
 
/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function wporg_section_developers_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'wporg' ); ?></p>
    <?php
}
 
/**
 * Pill field callbakc function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function wporg_field_pill_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'wporg_options' );
    ?>
    <select
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['wporg_custom_data'] ); ?>"
            name="wporg_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <option value="red" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'red', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'red pill', 'wporg' ); ?>
        </option>
        <option value="blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'blue', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'blue pill', 'wporg' ); ?>
        </option>
    </select>
    <p class="description">
        <?php esc_html_e( 'You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'wporg' ); ?>
    </p>
    <p class="description">
        <?php esc_html_e( 'You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'wporg' ); ?>
    </p>
    <?php
}
 
/**
 * Add the top level menu page.
 */
function wporg_options_page() {
    add_menu_page(
        'WPOrg',
        'WPOrg Options',
        'manage_options',
        'wporg',
        'wporg_options_page_html'
    );
}
 
 
/**
 * Register our wporg_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'wporg_options_page' );
 
 
/**
 * Top level menu callback function
 */
function wporg_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
 
    // add error/update messages
 
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
    }
 
    // show error/update messages
    settings_errors( 'wporg_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg"
            settings_fields( 'wporg' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'wporg' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}





add_action( 'admin_menu', 'mymenu_options_page' );
function mymenu_options_page() {
    add_menu_page(
        'MyMenu',
        'All Sub-menu',
        'manage_options',
        'mymenu',
        'mymenu_options_page_html',
        'dashicons-star-filled',
        90
	);
}
function mymenu_options_page_html() {
	echo '<b>My Top level menu</b>';
	return false;
}



function mysubmenu_options_page()
{
    add_submenu_page(
        'mymenu',
        'Mysubmenu',
        'Activity',
        'manage_options',
        'Mysubmenu',
		'mysubmenu_options_page_html',
    );
}
add_action('admin_menu', 'mysubmenu_options_page');
function mysubmenu_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return false;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="" method="post">
            <?php
            // output security fields for the registered setting "wporg_options"
            settings_fields( 'mysubmenu_options' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'mysubmenu' );
            // output save settings button
            submit_button( __( 'Save Settings', 'textdomain' ) );
            ?>
        </form>
    </div>
    <?php	
}
?>




<?php
//replace
/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */
 
/**
 * custom option and settings
 */



function replace_content( $text ) {
 $option=get_option( 'replace_options' );
	// echo $option['input1'];
	// echo $option['input2'];
	// echo $option['option'];
    if($option['option']=='exact') {
		$var=str_replace($option['input1'].' ',$option['input2'],$text);
		return $var;
	}	
	elseif($option['option']=='contains') {
		$var=str_replace($option['input1'],$option['input2'],$text);
		return $var;
	}	
}
add_filter( 'the_content', 'replace_content');
add_filter( 'the_title', 'replace_content');
add_filter( 'the_excerpt', 'replace_content');
add_filter( 'the_comment_text', 'replace_content');

function replace_settings_init() {
    // Register a new setting for "wporg" page.
    register_setting( 'replace', 'replace_options' );
 
    // Register a new section in the "wporg" page.
    add_settings_section(
        'replace_section_developers',
        __( 'This is the text replace form.', 'replace' ), 'replace_section_developers_callback',
        'replace'
    );
 
    // Register a new field in the "wporg_section_developers" section, inside the "wporg" page.
    add_settings_field(
        'from', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'From', 'replace' ),
        'replace_from',
        'replace',
        'replace_section_developers',
        array(
            'label_for'         => 'input1',
            'class'             => 'replace_row',
            'replace_custom_data' => 'custom',
        )
	);
	add_settings_field(
        'to', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'To', 'replace' ),
        'replace_to',
        'replace',
        'replace_section_developers',
        array(
            'label_for'         => 'input2',
            'class'             => 'replace_row',
            'replace_custom_data' => 'custom',
        )
	);
	add_settings_field(
        'exact', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Exact', 'replace' ),
        'replace_dropdown',
        'replace',
        'replace_section_developers',
        array(
            'label_for'         => 'option',
            'class'             => 'replace_row',
            'replace_custom_data' => 'custom',
        )
	);
}
 
/**
 * Register our wporg_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'replace_settings_init' );
 
 
/**
 * Custom option and settings:
 *  - callback functions
 */
 
 
/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function replace_section_developers_callback( $args ) {
    ?>
    
    <?php
}
 
/**
 * Pill field callbakc function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function replace_dropdown( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'replace_options' );
    ?>
    <select
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['replace_custom_data'] ); ?>"
            name="replace_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <option value="exact" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'exact', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'Exact', 'replace' ); ?>
        </option>
        <option value="contains" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'contains', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'Contains', 'replace' ); ?>
        </option>
    </select>
    <?php
}
 
function replace_from( $args ) {
	$options = get_option( 'replace_options' );
	?>
    <input type="text" name="replace_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id=<?php echo esc_attr( $args['label_for'] ); ?> value="<?php echo esc_attr($option['input1'])?>"/>
	<?php
}

function replace_to( $args ) {
	$options = get_option( 'replace_options' );
	?>
	<input type="text" name="replace_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id=<?php echo esc_attr( $args['label_for'] ); ?> value="<?php echo esc_attr($option['input2'])?>"  />
	<?php
}
/**
 * Add the top level menu page.
 */
function replace_options_page() {
    add_menu_page(
        'Replace',
        'Replace Text',
        'manage_options',
        'replace',
		'replace_options_page_html',
		'dashicons-welcome-write-blog'
    );
}
 
 
/**
 * Register our wporg_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'replace_options_page' );
 
 
/**
 * Top level menu callback function
 */
function replace_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
 
    // add error/update messages
 
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'replace_messages', 'replace_message', __( 'Settings Saved', 'replace' ), 'updated' );
    }
 
    // show error/update messages
    settings_errors( 'replace_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg"
            settings_fields( 'replace' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'replace' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

