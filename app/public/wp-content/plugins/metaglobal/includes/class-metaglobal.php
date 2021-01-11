<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Metaglobal
 * @subpackage Metaglobal/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Metaglobal
 * @subpackage Metaglobal/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Metaglobal {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Metaglobal_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'METAGLOBAL_VERSION' ) ) {

			$this->version = METAGLOBAL_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'metaglobal';

		$this->metaglobal_dependencies();
		$this->metaglobal_locale();
		$this->metaglobal_admin_hooks();
		$this->metaglobal_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Metaglobal_Loader. Orchestrates the hooks of the plugin.
	 * - Metaglobal_i18n. Defines internationalization functionality.
	 * - Metaglobal_Admin. Defines all hooks for the admin area.
	 * - Metaglobal_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function metaglobal_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-metaglobal-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-metaglobal-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-metaglobal-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-metaglobal-public.php';

		$this->loader = new Metaglobal_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Metaglobal_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function metaglobal_locale() {

		$plugin_i18n = new Metaglobal_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function metaglobal_admin_hooks() {

		$m_plugin_admin = new Metaglobal_Admin( $this->m_get_plugin_name(), $this->m_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $m_plugin_admin, 'm_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $m_plugin_admin, 'm_admin_enqueue_scripts' );

		// Add settings menu for metaglobal.
		$this->loader->add_action( 'admin_menu', $m_plugin_admin, 'm_options_page' );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $m_plugin_admin, 'm_admin_submenu_page', 15 );
		$this->loader->add_filter( 'm_general_settings_array', $m_plugin_admin, 'm_admin_general_settings_page', 10 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function metaglobal_public_hooks() {

		$m_plugin_public = new Metaglobal_Public( $this->m_get_plugin_name(), $this->m_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $m_plugin_public, 'm_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $m_plugin_public, 'm_public_enqueue_scripts' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function m_run() {
		$this->loader->m_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function m_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Metaglobal_Loader    Orchestrates the hooks of the plugin.
	 */
	public function m_get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function m_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_m_plug tabs.
	 *
	 * @return  Array       An key=>value pair of metaglobal tabs.
	 */
	public function mwb_m_plug_default_tabs() {

		$m_default_tabs = array();

		$m_default_tabs['metaglobal-general'] = array(
			'title'       => esc_html__( 'General Setting', 'metaglobal' ),
			'name'        => 'metaglobal-general',
		);
		$m_default_tabs = apply_filters( 'mwb_m_plugin_standard_admin_settings_tabs', $m_default_tabs );

		$m_default_tabs['metaglobal-system-status'] = array(
			'title'       => esc_html__( 'System Status', 'metaglobal' ),
			'name'        => 'metaglobal-system-status',
		);

		return $m_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since   1.0.0
	 * @param string $path path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_m_plug_load_template( $path, $params = array() ) {

		$m_file_path = METAGLOBAL_DIR_PATH . $path;

		if ( file_exists( $m_file_path ) ) {

			include $m_file_path;
		} else {

			/* translators: %s: file path */
			$m_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'metaglobal' ), $m_file_path );
			$this->mwb_m_plug_admin_notice( $m_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param  string $m_message    Message to display.
	 * @param  string $type       notice type, accepted values - error/update/update-nag.
	 * @since  1.0.0
	 */
	public static function mwb_m_plug_admin_notice( $m_message, $type = 'error' ) {

		$m_classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$m_classes .= 'updated is-dismissible';
				break;

			case 'update-nag':
				$m_classes .= 'update-nag is-dismissible';
				break;

			case 'success':
				$m_classes .= 'notice-success is-dismissible';
				break;

			default:
				$m_classes .= 'notice-error is-dismissible';
		}

		$m_notice  = '<div class="' . esc_attr( $m_classes ) . '">';
		$m_notice .= '<p>' . esc_html( $m_message ) . '</p>';
		$m_notice .= '</div>';

		echo wp_kses_post( $m_notice );
	}


	/**
	 * Show wordpress and server info.
	 *
	 * @return  Array $m_system_data       returns array of all wordpress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_m_plug_system_status() {
		global $wpdb;
		$m_system_status = array();
		$m_wordpress_status = array();
		$m_system_data = array();

		// Get the web server.
		$m_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$m_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'metaglobal' );

		// Get the server's IP address.
		$m_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$m_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$m_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : __( 'N/A (make sure exec function is enabled)', 'metaglobal' );

		// Get the server path.
		$m_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'metaglobal' );

		// Get the OS.
		$m_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'metaglobal' );

		// Get WordPress version.
		$m_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'metaglobal' );

		// Get and count active WordPress plugins.
		$m_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'metaglobal' );

		// See if this site is multisite or not.
		$m_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'metaglobal' ) : __( 'No', 'metaglobal' );

		// See if WP Debug is enabled.
		$m_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'metaglobal' ) : __( 'No', 'metaglobal' );

		// See if WP Cache is enabled.
		$m_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'metaglobal' ) : __( 'No', 'metaglobal' );

		// Get the total number of WordPress users on the site.
		$m_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'metaglobal' );

		// Get the number of published WordPress posts.
		$m_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'metaglobal' );

		// Get PHP memory limit.
		$m_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'metaglobal' );

		// Get the PHP error log path.
		$m_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'metaglobal' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$m_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'metaglobal' );

		// Get PHP max post size.
		$m_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'metaglobal' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$m_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$m_system_status['php_architecture'] = '64-bit';
		} else {
			$m_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$m_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'metaglobal' );

		// Show the number of processes currently running on the server.
		$m_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : __( 'N/A (make sure exec is enabled)', 'metaglobal' );

		// Get the memory usage.
		$m_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$m_system_status['is_windows'] = true;
			$m_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'metaglobal' );
		}

		// Get the memory limit.
		$m_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'metaglobal' );

		// Get the PHP maximum execution time.
		$m_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'metaglobal' );

		// Get outgoing IP address.
		$m_system_status['outgoing_ip'] = function_exists( 'file_get_contents' ) ? file_get_contents( 'http://ipecho.net/plain' ) : __( 'N/A (file_get_contents function does not exist)', 'metaglobal' );

		$m_system_data['php'] = $m_system_status;
		$m_system_data['wp'] = $m_wordpress_status;

		return $m_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param  string $m_components    html to display.
	 * @since  1.0.0
	 */
	public function mwb_m_plug_generate_html( $m_components = array() ) {
		if ( is_array( $m_components ) && ! empty( $m_components ) ) {
			foreach ( $m_components as $m_component ) {
				switch ( $m_component['type'] ) {

					case 'hidden':
					case 'number':
					case 'password':
					case 'email':
					case 'text':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $m_component['id'] ); ?>"><?php echo esc_html( $m_component['title'] ); // WPCS: XSS ok. ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $m_component['type'] ) ); ?>">
								<input
								name="<?php echo esc_attr( $m_component['id'] ); ?>"
								id="<?php echo esc_attr( $m_component['id'] ); ?>"
								type="<?php echo esc_attr( $m_component['type'] ); ?>"
								value="<?php echo esc_attr( $m_component['value'] ); ?>"
								class="<?php echo esc_attr( $m_component['class'] ); ?>"
								placeholder="<?php echo esc_attr( $m_component['placeholder'] ); ?>"
								/>
								<p class="m-descp-tip"><?php echo esc_html( $m_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'textarea':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $m_component['id'] ); ?>"><?php echo esc_html( $m_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $m_component['type'] ) ); ?>">
								<textarea
								name="<?php echo esc_attr( $m_component['id'] ); ?>"
								id="<?php echo esc_attr( $m_component['id'] ); ?>"
								class="<?php echo esc_attr( $m_component['class'] ); ?>"
								rows="<?php echo esc_attr( $m_component['rows'] ); ?>"
								cols="<?php echo esc_attr( $m_component['cols'] ); ?>"
								placeholder="<?php echo esc_attr( $m_component['placeholder'] ); ?>"
								><?php echo esc_textarea( $m_component['value'] ); // WPCS: XSS ok. ?></textarea>
								<p class="m-descp-tip"><?php echo esc_html( $m_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'select':
					case 'multiselect':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $m_component['id'] ); ?>"><?php echo esc_html( $m_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $m_component['type'] ) ); ?>">
								<select
								name="<?php echo esc_attr( $m_component['id'] ); ?><?php echo ( 'multiselect' === $m_component['type'] ) ? '[]' : ''; ?>"
								id="<?php echo esc_attr( $m_component['id'] ); ?>"
								class="<?php echo esc_attr( $m_component['class'] ); ?>"
								<?php echo 'multiselect' === $m_component['type'] ? 'multiple="multiple"' : ''; ?>
								>
								<?php
								foreach ( $m_component['options'] as $m_key => $m_val ) {
									?>
									<option value="<?php echo esc_attr( $m_key ); ?>"
										<?php
										if ( is_array( $m_component['value'] ) ) {
											selected( in_array( (string) $m_key, $m_component['value'], true ), true );
										} else {
											selected( $m_component['value'], (string) $m_key );
										}
										?>
										>
										<?php echo esc_html( $m_val ); ?>
									</option>
									<?php
								}
								?>
								</select> 
								<p class="m-descp-tip"><?php echo esc_html( $m_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'checkbox':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc"><?php echo esc_html( $m_component['title'] ); ?></th>
							<td class="forminp forminp-checkbox">
								<label for="<?php echo esc_attr( $m_component['id'] ); ?>"></label>
								<input
								name="<?php echo esc_attr( $m_component['id'] ); ?>"
								id="<?php echo esc_attr( $m_component['id'] ); ?>"
								type="checkbox"
								class="<?php echo esc_attr( isset( $m_component['class'] ) ? $m_component['class'] : '' ); ?>"
								value="1"
								<?php checked( $m_component['value'], '1' ); ?>
								/> 
								<span class="m-descp-tip"><?php echo esc_html( $m_component['description'] ); // WPCS: XSS ok. ?></span>

							</td>
						</tr>
						<?php
						break;

					case 'radio':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $m_component['id'] ); ?>"><?php echo esc_html( $m_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $m_component['type'] ) ); ?>">
								<fieldset>
									<span class="m-descp-tip"><?php echo esc_html( $m_component['description'] ); // WPCS: XSS ok. ?></span>
									<ul>
										<?php
										foreach ( $m_component['options'] as $m_radio_key => $m_radio_val ) {
											?>
											<li>
												<label><input
													name="<?php echo esc_attr( $m_component['id'] ); ?>"
													value="<?php echo esc_attr( $m_radio_key ); ?>"
													type="radio"
													class="<?php echo esc_attr( $m_component['class'] ); ?>"
												<?php checked( $m_radio_key, $m_component['value'] ); ?>
													/> <?php echo esc_html( $m_radio_val ); ?></label>
											</li>
											<?php
										}
										?>
									</ul>
								</fieldset>
							</td>
						</tr>
						<?php
						break;

					case 'button':
						?>
						<tr valign="top">
							<td scope="row">
								<input type="button" class="button button-primary" 
								name="<?php echo esc_attr( $m_component['id'] ); ?>"
								id="<?php echo esc_attr( $m_component['id'] ); ?>"
								value="<?php echo esc_attr( $m_component['button_text'] ); ?>"
								/>
							</td>
						</tr>
						<?php
						break;

					case 'submit':
						?>
						<tr valign="top">
							<td scope="row">
								<input type="submit" class="button button-primary" 
								name="<?php echo esc_attr( $m_component['id'] ); ?>"
								id="<?php echo esc_attr( $m_component['id'] ); ?>"
								value="<?php echo esc_attr( $m_component['button_text'] ); ?>"
								/>
							</td>
						</tr>
						<?php
						break;

					default:
						break;
				}
			}
		}
	}
}
