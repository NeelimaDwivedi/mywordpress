<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mymetabox
 * @subpackage Mymetabox/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mymetabox
 * @subpackage Mymetabox/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mymetabox_Admin {

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
	public function m_admin_enqueue_styles( $hook ) {

		wp_enqueue_style( 'mwb-m-select2-css', MYMETABOX_DIR_URL . 'admin/css/mymetabox-select2.css', array(), time(), 'all' );

		wp_enqueue_style( $this->plugin_name, MYMETABOX_DIR_URL . 'admin/css/mymetabox-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function m_admin_enqueue_scripts( $hook ) {

		wp_enqueue_script( 'mwb-m-select2', MYMETABOX_DIR_URL . 'admin/js/mymetabox-select2.js', array( 'jquery' ), time(), false );

		wp_register_script( $this->plugin_name . 'admin-js', MYMETABOX_DIR_URL . 'admin/js/mymetabox-admin.js', array( 'jquery', 'mwb-m-select2' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name . 'admin-js',
			'm_admin_param',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'reloadurl' => admin_url( 'admin.php?page=mymetabox_menu' ),
			)
		);

		wp_enqueue_script( $this->plugin_name . 'admin-js' );
	}

	/**
	 * Adding settings menu for mymetabox.
	 *
	 * @since    1.0.0
	 */
	public function m_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( __( 'MakeWebBetter', 'mymetabox' ), __( 'MakeWebBetter', 'mymetabox' ), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), MYMETABOX_DIR_URL . 'admin/images/mwb-logo.png', 15 );
			$m_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $m_menus ) && ! empty( $m_menus ) ) {
				foreach ( $m_menus as $m_key => $m_value ) {
					add_submenu_page( 'mwb-plugins', $m_value['name'], $m_value['name'], 'manage_options', $m_value['menu_link'], array( $m_value['instance'], $m_value['function'] ) );
				}
			}
		}
	}


	/**
	 * mymetabox m_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function m_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'            => __( 'mymetabox', 'mymetabox' ),
			'slug'            => 'mymetabox_menu',
			'menu_link'       => 'mymetabox_menu',
			'instance'        => $this,
			'function'        => 'm_options_menu_html',
		);
		return $menus;
	}


	/**
	 * mymetabox mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require MYMETABOX_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * mymetabox admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function m_options_menu_html() {

		include_once MYMETABOX_DIR_PATH . 'admin/partials/mymetabox-admin-display.php';
	}

	/**
	 * mymetabox admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $m_settings_general Settings fields.
	 */
	public function m_admin_general_settings_page( $m_settings_general ) {
		$m_settings_general = array(
			array(
				'title' => __( 'Text Field Demo', 'mymetabox' ),
				'type'  => 'text',
				'description'  => __( 'This is text field demo follow same structure for further use.', 'mymetabox' ),
				'id'    => 'm_text_demo',
				'value' => '',
				'class' => 'm-text-class',
				'placeholder' => __( 'Text Demo', 'mymetabox' ),
			),
			array(
				'title' => __( 'Number Field Demo', 'mymetabox' ),
				'type'  => 'number',
				'description'  => __( 'This is number field demo follow same structure for further use.', 'mymetabox' ),
				'id'    => 'm_number_demo',
				'value' => '',
				'class' => 'm-number-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Password Field Demo', 'mymetabox' ),
				'type'  => 'password',
				'description'  => __( 'This is password field demo follow same structure for further use.', 'mymetabox' ),
				'id'    => 'm_password_demo',
				'value' => '',
				'class' => 'm-password-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Textarea Field Demo', 'mymetabox' ),
				'type'  => 'textarea',
				'description'  => __( 'This is textarea field demo follow same structure for further use.', 'mymetabox' ),
				'id'    => 'm_textarea_demo',
				'value' => '',
				'class' => 'm-textarea-class',
				'rows' => '5',
				'cols' => '10',
				'placeholder' => __( 'Textarea Demo', 'mymetabox' ),
			),
			array(
				'title' => __( 'Select Field Demo', 'mymetabox' ),
				'type'  => 'select',
				'description'  => __( 'This is select field demo follow same structure for further use.', 'mymetabox' ),
				'id'    => 'm_select_demo',
				'value' => '',
				'class' => 'm-select-class',
				'placeholder' => __( 'Select Demo', 'mymetabox' ),
				'options' => array(
					'INR' => __( 'Rs.', 'mymetabox' ),
					'USD' => __( '$', 'mymetabox' ),
				),
			),
			array(
				'title' => __( 'Multiselect Field Demo', 'mymetabox' ),
				'type'  => 'multiselect',
				'description'  => __( 'This is multiselect field demo follow same structure for further use.', 'mymetabox' ),
				'id'    => 'm_multiselect_demo',
				'value' => '',
				'class' => 'm-multiselect-class mwb-defaut-multiselect',
				'placeholder' => __( 'Multiselect Demo', 'mymetabox' ),
				'options' => array(
					'INR' => __( 'Rs.', 'mymetabox' ),
					'USD' => __( '$', 'mymetabox' ),
				),
			),
			array(
				'title' => __( 'Checkbox Field Demo', 'mymetabox' ),
				'type'  => 'checkbox',
				'description'  => __( 'This is checkbox field demo follow same structure for further use.', 'mymetabox' ),
				'id'    => 'm_checkbox_demo',
				'value' => '',
				'class' => 'm-checkbox-class',
				'placeholder' => __( 'Checkbox Demo', 'mymetabox' ),
			),

			array(
				'title' => __( 'Radio Field Demo', 'mymetabox' ),
				'type'  => 'radio',
				'description'  => __( 'This is radio field demo follow same structure for further use.', 'mymetabox' ),
				'id'    => 'm_radio_demo',
				'value' => '',
				'class' => 'm-radio-class',
				'placeholder' => __( 'Radio Demo', 'mymetabox' ),
				'options' => array(
					'yes' => __( 'YES', 'mymetabox' ),
					'no' => __( 'NO', 'mymetabox' ),
				),
			),

			array(
				'type'  => 'button',
				'id'    => 'm_button_demo',
				'button_text' => __( 'Button Demo', 'mymetabox' ),
				'class' => 'm-button-class',
			),
		);
		return $m_settings_general;
	}
}
