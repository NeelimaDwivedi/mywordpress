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
 * @package           Metaglobal
 *
 * @wordpress-plugin
 * Plugin Name:       metaglobal
 * Plugin URI:        https://makewebbetter.com/product/metaglobal/
 * Description:       Your Basic Plugin
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       metaglobal
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
function define_metaglobal_constants() {

	metaglobal_constants( 'METAGLOBAL_VERSION', '1.0.0' );
	metaglobal_constants( 'METAGLOBAL_DIR_PATH', plugin_dir_path( __FILE__ ) );
	metaglobal_constants( 'METAGLOBAL_DIR_URL', plugin_dir_url( __FILE__ ) );
	metaglobal_constants( 'METAGLOBAL_SERVER_URL', 'https://makewebbetter.com' );
	metaglobal_constants( 'METAGLOBAL_ITEM_REFERENCE', 'metaglobal' );
}


/**
 * Callable function for defining plugin constants.
 *
 * @param   String $key    Key for contant.
 * @param   String $value   value for contant.
 * @since             1.0.0
 */
function metaglobal_constants( $key, $value ) {

	if ( ! defined( $key ) ) {

		define( $key, $value );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-metaglobal-activator.php
 */
function activate_metaglobal() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-metaglobal-activator.php';
	Metaglobal_Activator::metaglobal_activate();
	$mwb_m_active_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_m_active_plugin ) && ! empty( $mwb_m_active_plugin ) ) {
		$mwb_m_active_plugin['metaglobal'] = array(
			'plugin_name' => __( 'metaglobal', 'metaglobal' ),
			'active' => '1',
		);
	} else {
		$mwb_m_active_plugin = array();
		$mwb_m_active_plugin['metaglobal'] = array(
			'plugin_name' => __( 'metaglobal', 'metaglobal' ),
			'active' => '1',
		);
	}
	update_option( 'mwb_all_plugins_active', $mwb_m_active_plugin );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-metaglobal-deactivator.php
 */
function deactivate_metaglobal() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-metaglobal-deactivator.php';
	Metaglobal_Deactivator::metaglobal_deactivate();
	$mwb_m_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_m_deactive_plugin ) && ! empty( $mwb_m_deactive_plugin ) ) {
		foreach ( $mwb_m_deactive_plugin as $mwb_m_deactive_key => $mwb_m_deactive ) {
			if ( 'metaglobal' === $mwb_m_deactive_key ) {
				$mwb_m_deactive_plugin[ $mwb_m_deactive_key ]['active'] = '0';
			}
		}
	}
	update_option( 'mwb_all_plugins_active', $mwb_m_deactive_plugin );
}

register_activation_hook( __FILE__, 'activate_metaglobal' );
register_deactivation_hook( __FILE__, 'deactivate_metaglobal' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-metaglobal.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_metaglobal() {
	define_metaglobal_constants();

	$m_plugin_standard = new Metaglobal();
	$m_plugin_standard->m_run();
	$GLOBALS['m_mwb_m_obj'] = $m_plugin_standard;

}
run_metaglobal();

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
	require_once METAGLOBAL_DIR_PATH . 'includes/class-metaglobal-api-process.php';
	$mwb_m_api_obj = new Metaglobal_Api_Process();
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
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'metaglobal_settings_link' );

/**
 * Settings link.
 *
 * @since    1.0.0
 * @param   Array $links    Settings link array.
 */
function metaglobal_settings_link( $links ) {

	$my_link = array(
		'<a href="' . admin_url( 'admin.php?page=metaglobal_menu' ) . '">' . __( 'Settings', 'metaglobal' ) . '</a>',
	);
	return array_merge( $my_link, $links );
}





//global setting



/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */
 
/**
 * custom option and settings
 */
function globalreplace_settings_init() {
    // Register a new setting for "wporg" page.
    register_setting( 'globalreplace', 'globalreplace_options' );
 
    // Register a new section in the "wporg" page.
    add_settings_section(
        'globalreplace_section_developers',
        __( 'Global Word Replace.', 'globalreplace' ), 'globalreplace_section_developers_callback',
        'globalreplace'
    );
 
    // Register a new field in the "wporg_section_developers" section, inside the "wporg" page.
    add_settings_field(
        'from', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'From', 'globalreplace' ),
        'globalreplace_field_from',
        'globalreplace',
        'globalreplace_section_developers',
        array(
            'label_for'         => 'from_input',
            'class'             => 'globalreplace_row',
            'globalreplace_custom_data' => 'custom',
        )
	);
	add_settings_field(
        'to', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'To', 'globalreplace' ),
        'globalreplace_field_to',
        'globalreplace',
        'globalreplace_section_developers',
        array(
            'label_for'         => 'to_input',
            'class'             => 'globalreplace_row',
            'globalreplace_custom_data' => 'custom',
        )
	);
	add_settings_field(
        'select', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Select', 'globalreplace' ),
        'globalreplace_field_select',
        'globalreplace',
        'globalreplace_section_developers',
        array(
            'label_for'         => 'select_input',
            'class'             => 'globalreplace_row',
            'globalreplace_custom_data' => 'custom',
        )
    );
}
 
/**
 * Register our wporg_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'globalreplace_settings_init' );
 
 
/**
 * Custom option and settings:
 *  - callback functions
 */
 
 
/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function globalreplace_section_developers_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Global Replace setting.', 'globalreplace' ); ?></p>
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
function globalreplace_field_select( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'globalreplace_options' );
    ?>
    <select
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['globalreplace_custom_data'] ); ?>"
            name="globalreplace_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
			<option value="">Select something...</option>
        <option value="exact" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'exact', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'exact', 'globalreplace' ); ?>
        </option>
        <option value="contains" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'contains', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'contains', 'globalreplace' ); ?>
        </option>
    </select>
    <?php
}

function globalreplace_field_from( $args ) {
	$options = get_option( 'globalreplace_options' );
	?>
    <input type="text" name="globalreplace_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id=<?php echo esc_attr( $args['label_for'] ); ?> value="<?php echo esc_attr($options['from_input'])?>"/>
	<?php
}

function globalreplace_field_to( $args ) {
	$options = get_option( 'globalreplace_options' );
	?>
    <input type="text" name="globalreplace_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id=<?php echo esc_attr( $args['label_for'] ); ?> value="<?php echo esc_attr($options['to_input'])?>"/>
	<?php
}
 
/**
 * Add the top level menu page.
 */
function globalreplace_options_page() {
    add_menu_page(
        'Global Replace',
        'Global Replace',
        'manage_options',
        'globalreplace',
        'globalreplace_options_page_html'
    );
}
 
 
/**
 * Register our wporg_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'globalreplace_options_page' );
 
 
/**
 * Top level menu callback function
 */
function globalreplace_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
 
    // add error/update messages
 
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'globalreplace_messages', 'globalreplace_message', __( 'Settings Saved', 'globalreplace' ), 'updated' );
    }
 
    // show error/update messages
    settings_errors( 'globalreplace_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg"
            settings_fields( 'globalreplace' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'globalreplace' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}







//custom post meta box

function metasetting_add_custom_box() {
    $screens = [ 'post', 'metasetting_cpt'];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'metasetting_box_id',                 // Unique ID
            'Custom Meta Box Title',      // Box title
            'metasetting_custom_box_html',  // Content callback, must be of type callable
            $screen                            // Post type
        );
    }
}
add_action( 'add_meta_boxes', 'metasetting_add_custom_box' );

function metasetting_custom_box_html( $post ) {
    $value= get_post_meta( $post->ID, '_metasetting_mymeta', true );
	// print_r($value);die('hello');
    ?>
    <div class="postbox p-2">
        <label for="metasetting-from"><b>From</b></label>
        <input type="text" id="metasetting-from" name="metasetting-from" value="<?php echo isset($value['from'])?$value['from']:" "; ?>" >
    </div>
    <!--- to field-->
	<?php
	$value= get_post_meta( $post->ID, '_metasetting_mymeta', true );
	?>
    <div class="postbox p-2">
        <label for="metasetting-to"><b>To</b></label>
        <input type="text" id="metasetting-to" name="metasetting-to" value="<?php echo isset($value['to'])?$value['to']:" "; ?>" >
    </div>
    <!--- select field-->
	<?php
	$value= get_post_meta( $post->ID, '_metasetting_mymeta', true );
	?>
    <div class="postbox p-2">
    <label for="metasetting-select"><b>Select</b></label>
    <select name="metasetting-select" id="metasetting-select" >
        <option value="">Select something...</option>
        <option value="exact" <?php echo isset( $value['select']  ) ? ( selected( $value['select'] , 'exact', false ) ) : ( '' ); ?>><?php esc_html_e( 'exact', 'metasetting' ); ?></option>
        <option value="contains" <?php echo isset( $value['select'] ) ? ( selected( $value['select'] , 'contains', false ) ) : ( '' ); ?>><?php esc_html_e( 'contains', 'metasetting' ); ?></option>
    </select>
    </div>
    <?php
}
function metasetting_save_postdata( $post_id ) {
    $post=get_post_type( $post_id );
	$arr=array('select'=>$_POST['metasetting-select'], 'from'=>$_POST['metasetting-from'], 'to'=>$_POST['metasetting-to']);
	if ( array_key_exists( 'metasetting-select', $_POST ) && array_key_exists( 'metasetting-from', $_POST ) && array_key_exists( 'metasetting-to', $_POST )) {
        update_post_meta(
            $post_id,
            '_metasetting_mymeta',
            $arr
        );
    }
}
add_action( 'save_post', 'metasetting_save_postdata' );

function metasetting_metacontent( $text ) {
	global $post;
	$metapost=get_post_meta($post->ID, '_metasetting_mymeta', true);
	$from=$metapost['from'];
	$to=$metapost['to'];
	$select=$metapost['select'];
	if($from!='' && $to!='') {
	   if($select=='exact') {
		   $var=str_replace(" " .$from.  " "," ".$to." ",$text);
		   return $var;
	   }	
	   elseif($select=='contains') {
		   $var=str_replace($from,$to,$text);
		   return $var;
	   }
	} else {
		$option=get_option( 'globalreplace_options' );
	   if($option['select_input']=='exact') {
		   $var=str_replace(" " .$option['from_input']. " ",$option['to_input']." ",$text);
		   return $var;
	   }	
	   elseif($option['select_input']=='contains') {
		   $var=str_replace($option['from_input'],$option['to_input'],$text);
		   return $var;
	   }	
	}	
}
   



   //cpt


   function demo_custom_post_type() {
    register_post_type('demo_product',
        array(
            'labels'      => array(
                'name'          => __('Products', 'metaglobal'),
				'singular_name' => __('Product', 'metaglobal'),
				'featured_image'=>__('Product Image', 'metaglobal'),
				'set_featured_image'=>__('Set Product Image', 'metaglobal'),
				'remove_featured_image'=>__('Remove Image', 'metaglobal'),
				'use_featured_image'=>__('Use Image', 'metaglobal'),
				'archives'=>__('Food Products', 'metaglobal'),
				'add_new'=>__('Add Product', 'metaglobal'),
				'add_new_item'=>__('Add New Product', 'metaglobal'),
            ),
                'public'      => true,
				'has_archive' => 'product',
				'rewrite'=>array('has_front'=>true),
				'menu_icon'=>'dashicons-screenoptions',
				'supports'=>array('title', 'editor', 'thumbnail'),
                'show_in_rest'=>true,
                'show_in_admin_bar'=>true,
        )
    );
}
add_action('init', 'demo_custom_post_type');



function demo_register_category_taxonomy() {
    $labels= array(
        'name'=>__('Product Categories', 'metaglobal'),
        'singular_name'=>__('Product Category', 'metaglobal'),
        'add_new_item'=>__('Add New Product Category', 'metaglobal'),
    );
    $args=array(
        'labels'=>$labels,
        'public'=>true,
        'show_ui'=> true,
        'show_in_nav_menus'   => true,
        'show_admin_column'=>true,
        'show_in_qick_edit'=>true,
        'show_in_rest'=>true,
        'hierarchical'=>true,
        'rewrite'=>array('hierarchical'=>true, 'slug'=>'product_category', 'with_front'=>false),
    );
    $post_types= array('demo_product');

    register_taxonomy('product_category', $post_types, $args);
}
add_action('init', 'demo_register_category_taxonomy');



function demo_register_tag_taxonomy() {
    $labels= array(
        'name'=>__('Product Tags', 'metaglobal'),
        'Singular_name'=>__('Product Tag', 'metaglobal'),
        'add_new_item'=>__('Add New Tag', 'metaglobal'),
    );
    $args=array(
        'labels'=>$labels,
        'public'=>true,
        'show_admin_column'=>true,
        'show_in_qick_edit'=>false,
        'show_in_rest'=>true,
    );
     $post_types= array('demo_product');

    register_taxonomy('product_tag', $post_types, $args);
}
add_action('init', 'demo_register_tag_taxonomy');

// cpt metabox


function productmeta_add_custom_box() {
    $screens = [ 'demo_product', 'metasetting_cpt'];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'metasetting_box_id',                 // Unique ID
            'Custom Meta Box Title',      // Box title
            'productmeta_custom_box_html',  // Content callback, must be of type callable
            $screen                            // Post type
        );
    }
}
add_action( 'add_meta_boxes', 'productmeta_add_custom_box' );


function productmeta_custom_box_html( $post ) {
    $value= get_post_meta( $post->ID, '_product_meta', true );
	// print_r($value);die('hello');
    ?>
    <div class="postbox p-2">
        <label for="metasetting-price"><b>Price</b></label>
        <input type="text" id="metasetting-price" name="metasetting-price" value="<?php echo isset($value['price'])? $value['price']:" ";  ?>" >
    </div>
    <!--- to field-->
	<?php
	$value= get_post_meta( $post->ID, '_product_meta', true );
	?>
    <div class="postbox p-2">
        <label for="metasetting-sku"><b>SKU</b></label>
        <input type="text" id="metasetting-sku" name="metasetting-sku" value="<?php echo isset($value['sku'])? $value['sku']:" ";  ?>" >
    </div>

    <?php
    $value= get_post_meta( $post->ID, '_product_meta', true );
	?>
    <div class="postbox p-2">
        <label for="metasetting-stock"><b>Stock</b></label>
        <input type="text" id="metasetting-stock" name="metasetting-stock" value="<?php echo isset($value['stock'])? $value['stock']:" "; ?>" >
    </div>
    <?php
}
function product_save_postdata( $post_id ) {
    $post_type = get_post_type();
    if($post_type=='demo_product') {
        $arr=array('price'=>$_POST['metasetting-price'], 'sku'=>$_POST['metasetting-sku'], 'stock'=>$_POST['metasetting-stock']);
        if ( array_key_exists( 'metasetting-price', $_POST ) && array_key_exists( 'metasetting-sku', $_POST ) && array_key_exists( 'metasetting-stock', $_POST )) {
            update_post_meta(
                $post_id,
                '_product_meta',
                $arr
            );
        }
    } else {
        add_filter( 'the_content', 'metasetting_metacontent');
    }
}
add_action( 'save_post', 'product_save_postdata' );


//user

function demo_customer_role() {
    add_role(
        'customer_role',
        'Customer Role',
        array(
            'read'         => true,
            'edit_posts'   => true,
            'upload_files' => true,
        ),
    );
}
 
// Add the simple_role.
add_action( 'init', 'demo_customer_role' );

function custom_restrict_admin()
{
  if (!current_user_can('administrator') && ! is_admin())
  {
    show_admin_bar(false); //remove admin bar
  }
}
add_action( 'init', 'custom_restrict_admin' );


function customer_register() {
    $errors =array();
    if(isset($_POST['registersubmit'])) {
        $user_name=isset($_POST['uname'])?$_POST['uname']:'';
        $user_email=isset($_POST['uemail'])?$_POST['uemail']:'';
        $user_password=isset($_POST['upass'])?$_POST['upass']:'';
        $user_address=isset($_POST['uaddress'])?$_POST['uaddress']:'';
        $user_mobile=isset($_POST['umob'])?$_POST['umob']:'';
        $user_dob=isset($_POST['udob'])?$_POST['udob']:'';
       
    
        if ($user_name=='') {
            $errors[] =array('msg'=>'Username is required');
        } else {
            if (!preg_match("/^[a-zA-Z-' ]*$/" ,$user_name)) {
                $errors[]=array('msg'=>'Only letters and white space allowed in name') ;
            }
        }
        if($user_password=='') {
            $errors[] =array('msg'=>'Password is required');
        }
        if ($user_mobile=='') {
            $errors[] =array('msg'=>'Mobile no. is required');
        } else {
            if (!preg_match('/^[0-9]{10}+$/', $user_mobile)) {
                $errors[]=array('msg'=>'Invalid Mobile no. format');
            }
        }
        if($user_email=='') {
            $errors[] =array('msg'=>'Email is required');
        }else {
            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $errors[] =array('msg'=>'Invalid email format');
            }
        }
        if($user_address=='') {
            $errors[] =array('msg'=>'Address is required');
        }
        if($user_dob=='') {
            $errors[] =array('msg'=>'DOB is required');
        }

        if(sizeof($errors)==0) {
            $user_id=wp_create_user($user_name, $user_password, $user_email);
            $user_data = [
                'user_name' => $user_name,
                'user_password'  => $user_password,
                'user_email'   => $user_email,
                'role'=>'Customer Role'
            ];
            wp_insert_user($user_data);
            add_user_meta($user_id, 'address',$user_address);
            add_user_meta($user_id, 'mobile',$user_mobile);
            add_user_meta($user_id, 'dob',$user_dob);
            print_r($user_id);

            echo '<script>alert("Valid Info")</script>';
        } else {
            foreach($errors as $v){
                echo '<ul>';
                foreach($v as $k1=>$v1) {
                    echo '<li>'.$v1.'</li>';
                }
                echo '</ul>';
            }
            
        }
    }
}

add_action('init', 'customer_register');

function customer_login() {
    
    if (isset($_POST['loginsubmit'])) {
        $creds = array();
        $username=esc_attr($_POST["username"]);
        $userpassword=esc_attr($_POST["userpass"]);
        $creds['user_login'] = $username;
        $creds['user_password'] = $userpassword;
        $creds['remember'] = true;        
        $user = wp_signon( $creds, false );
        print_r($user);
        if ( is_wp_error($user) ) {
            echo $user->get_error_message();
        }else {
            wp_safe_redirect(home_url());                                     
            
        }
	        
    }
    


}
add_action('init', 'customer_login');


function my_wp_nav_menu_args( $args = '' ) {
 
    if( is_user_logged_in() ) { 
        $args['menu'] = 'mymenu2';
    } else { 
        $args['menu'] = 'mymenu';
    } 
        return $args;
}
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );

 function customer_meta_update() {
    $errors=array();
    if(isset($_POST['updatersubmit'])) {
        $user_id=get_current_user_id();
        $user_address=$_POST['uaddress'];
        $user_mobile=$_POST['umob'];
        $user_dob=$_POST['udob'];
        if ($user_mobile=='') {
            $errors[] =array('msg'=>'Mobile no. is required');
        } else {
            if (!preg_match('/^[0-9]{10}+$/', $user_mobile)) {
                $errors[]=array('msg'=>'Invalid Mobile no. format');
            }
        }
        if($user_address=='') {
            $errors[] =array('msg'=>'Address is required');
        }
        if($user_dob=='') {
            $errors[] =array('msg'=>'DOB is required');
        }
        if(sizeof($errors)==0) {
            update_usermeta($user_id, 'address', $user_address);
            update_usermeta($user_id, 'mobile', $user_mobile);
            update_usermeta($user_id, 'dob', $user_dob);
            echo '<script>alert("Valid Info")</script>';
        }else {
            foreach($errors as $v){
                echo '<ul>';
                foreach($v as $k1=>$v1) {
                    echo '<li>'.$v1.'</li>';
                }
                echo '</ul>';
            }
        }
    }
 } 
 add_action('init', 'customer_meta_update');


 //logout function
 add_action('init', 'check_logout');

function check_logout() {
    if(isset($_GET['logaction'])) {
        wp_logout();
        wp_safe_redirect(site_url());
    }
}



 
//function demo_simple_role_caps() {
    // Gets the simple_role role object.
    //$role = get_role( 'simple_role' );
 
    // Add a new capability.
    //$role->add_cap( 'edit_others_posts', true );
//}
 
// Add simple_role capabilities, priority must be after the initial role definition.
//add_action( 'init', 'demo_simple_role_caps', 11 ); 

//function demo_simple_capability_remove() {
    //$role=get_role('simple_role');
    //unset( $role->capabilities[ 'edit_others_posts' ] );
    //wp_roles()->remove_cap( $role->name, 'edit_others_posts' );
    
//}
//add_action( 'init', 'demo_simple_capability_remove' );