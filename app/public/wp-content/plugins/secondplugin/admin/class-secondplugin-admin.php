<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Secondplugin
 * @subpackage Secondplugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Secondplugin
 * @subpackage Secondplugin/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Secondplugin_Admin {

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
	public function s_admin_enqueue_styles( $hook ) {

		wp_enqueue_style( 'mwb-s-select2-css', SECONDPLUGIN_DIR_URL . 'admin/css/secondplugin-select2.css', array(), time(), 'all' );

		wp_enqueue_style( $this->plugin_name, SECONDPLUGIN_DIR_URL . 'admin/css/secondplugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function s_admin_enqueue_scripts( $hook ) {

		wp_enqueue_script( 'mwb-s-select2', SECONDPLUGIN_DIR_URL . 'admin/js/secondplugin-select2.js', array( 'jquery' ), time(), false );

		wp_register_script( $this->plugin_name . 'admin-js', SECONDPLUGIN_DIR_URL . 'admin/js/secondplugin-admin.js', array( 'jquery', 'mwb-s-select2' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name . 'admin-js',
			's_admin_param',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'reloadurl' => admin_url( 'admin.php?page=secondplugin_menu' ),
			)
		);

		wp_enqueue_script( $this->plugin_name . 'admin-js' );
	}

	/**
	 * Adding settings menu for secondplugin.
	 *
	 * @since    1.0.0
	 */
	public function s_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( __( 'MakeWebBetter', 'secondplugin' ), __( 'MakeWebBetter', 'secondplugin' ), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), SECONDPLUGIN_DIR_URL . 'admin/images/mwb-logo.png', 15 );
			$s_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $s_menus ) && ! empty( $s_menus ) ) {
				foreach ( $s_menus as $s_key => $s_value ) {
					add_submenu_page( 'mwb-plugins', $s_value['name'], $s_value['name'], 'manage_options', $s_value['menu_link'], array( $s_value['instance'], $s_value['function'] ) );
				}
			}
		}
	}


	/**
	 * secondplugin s_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function s_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'            => __( 'secondplugin', 'secondplugin' ),
			'slug'            => 'secondplugin_menu',
			'menu_link'       => 'secondplugin_menu',
			'instance'        => $this,
			'function'        => 's_options_menu_html',
		);
		return $menus;
	}


	/**
	 * secondplugin mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require SECONDPLUGIN_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * secondplugin admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function s_options_menu_html() {

		include_once SECONDPLUGIN_DIR_PATH . 'admin/partials/secondplugin-admin-display.php';
	}

	/**
	 * secondplugin admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $s_settings_general Settings fields.
	 */
	public function s_admin_general_settings_page( $s_settings_general ) {
		$s_settings_general = array(
			array(
				'title' => __( 'Text Field Demo', 'secondplugin' ),
				'type'  => 'text',
				'description'  => __( 'This is text field demo follow same structure for further use.', 'secondplugin' ),
				'id'    => 's_text_demo',
				'value' => '',
				'class' => 's-text-class',
				'placeholder' => __( 'Text Demo', 'secondplugin' ),
			),
			array(
				'title' => __( 'Number Field Demo', 'secondplugin' ),
				'type'  => 'number',
				'description'  => __( 'This is number field demo follow same structure for further use.', 'secondplugin' ),
				'id'    => 's_number_demo',
				'value' => '',
				'class' => 's-number-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Password Field Demo', 'secondplugin' ),
				'type'  => 'password',
				'description'  => __( 'This is password field demo follow same structure for further use.', 'secondplugin' ),
				'id'    => 's_password_demo',
				'value' => '',
				'class' => 's-password-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Textarea Field Demo', 'secondplugin' ),
				'type'  => 'textarea',
				'description'  => __( 'This is textarea field demo follow same structure for further use.', 'secondplugin' ),
				'id'    => 's_textarea_demo',
				'value' => '',
				'class' => 's-textarea-class',
				'rows' => '5',
				'cols' => '10',
				'placeholder' => __( 'Textarea Demo', 'secondplugin' ),
			),
			array(
				'title' => __( 'Select Field Demo', 'secondplugin' ),
				'type'  => 'select',
				'description'  => __( 'This is select field demo follow same structure for further use.', 'secondplugin' ),
				'id'    => 's_select_demo',
				'value' => '',
				'class' => 's-select-class',
				'placeholder' => __( 'Select Demo', 'secondplugin' ),
				'options' => array(
					'INR' => __( 'Rs.', 'secondplugin' ),
					'USD' => __( '$', 'secondplugin' ),
				),
			),
			array(
				'title' => __( 'Multiselect Field Demo', 'secondplugin' ),
				'type'  => 'multiselect',
				'description'  => __( 'This is multiselect field demo follow same structure for further use.', 'secondplugin' ),
				'id'    => 's_multiselect_demo',
				'value' => '',
				'class' => 's-multiselect-class mwb-defaut-multiselect',
				'placeholder' => __( 'Multiselect Demo', 'secondplugin' ),
				'options' => array(
					'INR' => __( 'Rs.', 'secondplugin' ),
					'USD' => __( '$', 'secondplugin' ),
				),
			),
			array(
				'title' => __( 'Checkbox Field Demo', 'secondplugin' ),
				'type'  => 'checkbox',
				'description'  => __( 'This is checkbox field demo follow same structure for further use.', 'secondplugin' ),
				'id'    => 's_checkbox_demo',
				'value' => '',
				'class' => 's-checkbox-class',
				'placeholder' => __( 'Checkbox Demo', 'secondplugin' ),
			),

			array(
				'title' => __( 'Radio Field Demo', 'secondplugin' ),
				'type'  => 'radio',
				'description'  => __( 'This is radio field demo follow same structure for further use.', 'secondplugin' ),
				'id'    => 's_radio_demo',
				'value' => '',
				'class' => 's-radio-class',
				'placeholder' => __( 'Radio Demo', 'secondplugin' ),
				'options' => array(
					'yes' => __( 'YES', 'secondplugin' ),
					'no' => __( 'NO', 'secondplugin' ),
				),
			),

			array(
				'type'  => 'button',
				'id'    => 's_button_demo',
				'button_text' => __( 'Button Demo', 'secondplugin' ),
				'class' => 's-button-class',
			),
		);
		return $s_settings_general;
	}
}
