<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    My_First_Plugin
 * @subpackage My_First_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    My_First_Plugin
 * @subpackage My_First_Plugin/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class My_First_Plugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function mfp_admin_enqueue_styles( $hook ) {

		wp_enqueue_style( 'mwb-mfp-select2-css', MY_FIRST_PLUGIN_DIR_URL . 'admin/css/my-first-plugin-select2.css', array(), time(), 'all' );

		wp_enqueue_style( $this->plugin_name, MY_FIRST_PLUGIN_DIR_URL . 'admin/css/my-first-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function mfp_admin_enqueue_scripts( $hook ) {

		wp_enqueue_script( 'mwb-mfp-select2', MY_FIRST_PLUGIN_DIR_URL . 'admin/js/my-first-plugin-select2.js', array( 'jquery' ), time(), false );

		wp_register_script( $this->plugin_name . 'admin-js', MY_FIRST_PLUGIN_DIR_URL . 'admin/js/my-first-plugin-admin.js', array( 'jquery', 'mwb-mfp-select2' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name . 'admin-js',
			'mfp_admin_param',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'reloadurl' => admin_url( 'admin.php?page=my_first_plugin_menu' ),
			)
		);

		wp_enqueue_script( $this->plugin_name . 'admin-js' );
	}

	/**
	 * Adding settings menu for my first plugin.
	 *
	 * @since    1.0.0
	 */
	public function mfp_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( __( 'MakeWebBetter', 'my-first-plugin' ), __( 'MakeWebBetter', 'my-first-plugin' ), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), MY_FIRST_PLUGIN_DIR_URL . 'admin/images/mwb-logo.png', 15 );
			$mfp_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $mfp_menus ) && ! empty( $mfp_menus ) ) {
				foreach ( $mfp_menus as $mfp_key => $mfp_value ) {
					add_submenu_page( 'mwb-plugins', $mfp_value['name'], $mfp_value['name'], 'manage_options', $mfp_value['menu_link'], array( $mfp_value['instance'], $mfp_value['function'] ) );
				}
			}
		}
	}


	/**
	 * my first plugin mfp_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function mfp_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'            => __( 'my first plugin', 'my-first-plugin' ),
			'slug'            => 'my_first_plugin_menu',
			'menu_link'       => 'my_first_plugin_menu',
			'instance'        => $this,
			'function'        => 'mfp_options_menu_html',
		);
		return $menus;
	}


	/**
	 * my first plugin mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require MY_FIRST_PLUGIN_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * my first plugin admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function mfp_options_menu_html() {

		include_once MY_FIRST_PLUGIN_DIR_PATH . 'admin/partials/my-first-plugin-admin-display.php';
	}

	/**
	 * my first plugin admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $mfp_settings_general Settings fields.
	 */
	public function mfp_admin_general_settings_page( $mfp_settings_general ) {
		$mfp_settings_general = array(
			array(
				'title' => __( 'Text Field Demo', 'my-first-plugin' ),
				'type'  => 'text',
				'description'  => __( 'This is text field demo follow same structure for further use.', 'my-first-plugin' ),
				'id'    => 'mfp_text_demo',
				'value' => '',
				'class' => 'mfp-text-class',
				'placeholder' => __( 'Text Demo', 'my-first-plugin' ),
			),
			array(
				'title' => __( 'Number Field Demo', 'my-first-plugin' ),
				'type'  => 'number',
				'description'  => __( 'This is number field demo follow same structure for further use.', 'my-first-plugin' ),
				'id'    => 'mfp_number_demo',
				'value' => '',
				'class' => 'mfp-number-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Password Field Demo', 'my-first-plugin' ),
				'type'  => 'password',
				'description'  => __( 'This is password field demo follow same structure for further use.', 'my-first-plugin' ),
				'id'    => 'mfp_password_demo',
				'value' => '',
				'class' => 'mfp-password-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Textarea Field Demo', 'my-first-plugin' ),
				'type'  => 'textarea',
				'description'  => __( 'This is textarea field demo follow same structure for further use.', 'my-first-plugin' ),
				'id'    => 'mfp_textarea_demo',
				'value' => '',
				'class' => 'mfp-textarea-class',
				'rows' => '5',
				'cols' => '10',
				'placeholder' => __( 'Textarea Demo', 'my-first-plugin' ),
			),
			array(
				'title' => __( 'Select Field Demo', 'my-first-plugin' ),
				'type'  => 'select',
				'description'  => __( 'This is select field demo follow same structure for further use.', 'my-first-plugin' ),
				'id'    => 'mfp_select_demo',
				'value' => '',
				'class' => 'mfp-select-class',
				'placeholder' => __( 'Select Demo', 'my-first-plugin' ),
				'options' => array(
					'INR' => __( 'Rs.', 'my-first-plugin' ),
					'USD' => __( '$', 'my-first-plugin' ),
				),
			),
			array(
				'title' => __( 'Multiselect Field Demo', 'my-first-plugin' ),
				'type'  => 'multiselect',
				'description'  => __( 'This is multiselect field demo follow same structure for further use.', 'my-first-plugin' ),
				'id'    => 'mfp_multiselect_demo',
				'value' => '',
				'class' => 'mfp-multiselect-class mwb-defaut-multiselect',
				'placeholder' => __( 'Multiselect Demo', 'my-first-plugin' ),
				'options' => array(
					'INR' => __( 'Rs.', 'my-first-plugin' ),
					'USD' => __( '$', 'my-first-plugin' ),
				),
			),
			array(
				'title' => __( 'Checkbox Field Demo', 'my-first-plugin' ),
				'type'  => 'checkbox',
				'description'  => __( 'This is checkbox field demo follow same structure for further use.', 'my-first-plugin' ),
				'id'    => 'mfp_checkbox_demo',
				'value' => '',
				'class' => 'mfp-checkbox-class',
				'placeholder' => __( 'Checkbox Demo', 'my-first-plugin' ),
			),

			array(
				'title' => __( 'Radio Field Demo', 'my-first-plugin' ),
				'type'  => 'radio',
				'description'  => __( 'This is radio field demo follow same structure for further use.', 'my-first-plugin' ),
				'id'    => 'mfp_radio_demo',
				'value' => '',
				'class' => 'mfp-radio-class',
				'placeholder' => __( 'Radio Demo', 'my-first-plugin' ),
				'options' => array(
					'yes' => __( 'YES', 'my-first-plugin' ),
					'no' => __( 'NO', 'my-first-plugin' ),
				),
			),

			array(
				'type'  => 'button',
				'id'    => 'mfp_button_demo',
				'button_text' => __( 'Button Demo', 'my-first-plugin' ),
				'class' => 'mfp-button-class',
			),
		);
		return $mfp_settings_general;
	}
}
