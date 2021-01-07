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
 * @package    My_First_Plugin
 * @subpackage My_First_Plugin/includes
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
 * @package    My_First_Plugin
 * @subpackage My_First_Plugin/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class My_First_Plugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      My_First_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
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

		if ( defined( 'MY_FIRST_PLUGIN_VERSION' ) ) {

			$this->version = MY_FIRST_PLUGIN_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'my-first-plugin';

		$this->my_first_plugin_dependencies();
		$this->my_first_plugin_locale();
		$this->my_first_plugin_admin_hooks();
		$this->my_first_plugin_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - My_First_Plugin_Loader. Orchestrates the hooks of the plugin.
	 * - My_First_Plugin_i18n. Defines internationalization functionality.
	 * - My_First_Plugin_Admin. Defines all hooks for the admin area.
	 * - My_First_Plugin_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function my_first_plugin_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-my-first-plugin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-my-first-plugin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-my-first-plugin-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-my-first-plugin-public.php';

		$this->loader = new My_First_Plugin_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the My_First_Plugin_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function my_first_plugin_locale() {

		$plugin_i18n = new My_First_Plugin_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function my_first_plugin_admin_hooks() {

		$mfp_plugin_admin = new My_First_Plugin_Admin( $this->mfp_get_plugin_name(), $this->mfp_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $mfp_plugin_admin, 'mfp_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $mfp_plugin_admin, 'mfp_admin_enqueue_scripts' );

		// Add settings menu for my first plugin.
		$this->loader->add_action( 'admin_menu', $mfp_plugin_admin, 'mfp_options_page' );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $mfp_plugin_admin, 'mfp_admin_submenu_page', 15 );
		$this->loader->add_filter( 'mfp_general_settings_array', $mfp_plugin_admin, 'mfp_admin_general_settings_page', 10 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function my_first_plugin_public_hooks() {

		$mfp_plugin_public = new My_First_Plugin_Public( $this->mfp_get_plugin_name(), $this->mfp_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $mfp_plugin_public, 'mfp_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $mfp_plugin_public, 'mfp_public_enqueue_scripts' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function mfp_run() {
		$this->loader->mfp_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function mfp_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    My_First_Plugin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function mfp_get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function mfp_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_mfp_plug tabs.
	 *
	 * @return  Array       An key=>value pair of my first plugin tabs.
	 */
	public function mwb_mfp_plug_default_tabs() {

		$mfp_default_tabs = array();

		$mfp_default_tabs['my-first-plugin-general'] = array(
			'title'       => esc_html__( 'General Setting', 'my-first-plugin' ),
			'name'        => 'my-first-plugin-general',
		);
		$mfp_default_tabs = apply_filters( 'mwb_mfp_plugin_standard_admin_settings_tabs', $mfp_default_tabs );

		$mfp_default_tabs['my-first-plugin-system-status'] = array(
			'title'       => esc_html__( 'System Status', 'my-first-plugin' ),
			'name'        => 'my-first-plugin-system-status',
		);

		return $mfp_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since   1.0.0
	 * @param string $path path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_mfp_plug_load_template( $path, $params = array() ) {

		$mfp_file_path = MY_FIRST_PLUGIN_DIR_PATH . $path;

		if ( file_exists( $mfp_file_path ) ) {

			include $mfp_file_path;
		} else {

			/* translators: %s: file path */
			$mfp_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'my-first-plugin' ), $mfp_file_path );
			$this->mwb_mfp_plug_admin_notice( $mfp_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param  string $mfp_message    Message to display.
	 * @param  string $type       notice type, accepted values - error/update/update-nag.
	 * @since  1.0.0
	 */
	public static function mwb_mfp_plug_admin_notice( $mfp_message, $type = 'error' ) {

		$mfp_classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$mfp_classes .= 'updated is-dismissible';
				break;

			case 'update-nag':
				$mfp_classes .= 'update-nag is-dismissible';
				break;

			case 'success':
				$mfp_classes .= 'notice-success is-dismissible';
				break;

			default:
				$mfp_classes .= 'notice-error is-dismissible';
		}

		$mfp_notice  = '<div class="' . esc_attr( $mfp_classes ) . '">';
		$mfp_notice .= '<p>' . esc_html( $mfp_message ) . '</p>';
		$mfp_notice .= '</div>';

		echo wp_kses_post( $mfp_notice );
	}


	/**
	 * Show wordpress and server info.
	 *
	 * @return  Array $mfp_system_data       returns array of all wordpress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_mfp_plug_system_status() {
		global $wpdb;
		$mfp_system_status = array();
		$mfp_wordpress_status = array();
		$mfp_system_data = array();

		// Get the web server.
		$mfp_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$mfp_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'my-first-plugin' );

		// Get the server's IP address.
		$mfp_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$mfp_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$mfp_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : __( 'N/A (make sure exec function is enabled)', 'my-first-plugin' );

		// Get the server path.
		$mfp_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'my-first-plugin' );

		// Get the OS.
		$mfp_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'my-first-plugin' );

		// Get WordPress version.
		$mfp_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'my-first-plugin' );

		// Get and count active WordPress plugins.
		$mfp_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'my-first-plugin' );

		// See if this site is multisite or not.
		$mfp_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'my-first-plugin' ) : __( 'No', 'my-first-plugin' );

		// See if WP Debug is enabled.
		$mfp_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'my-first-plugin' ) : __( 'No', 'my-first-plugin' );

		// See if WP Cache is enabled.
		$mfp_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'my-first-plugin' ) : __( 'No', 'my-first-plugin' );

		// Get the total number of WordPress users on the site.
		$mfp_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'my-first-plugin' );

		// Get the number of published WordPress posts.
		$mfp_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'my-first-plugin' );

		// Get PHP memory limit.
		$mfp_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'my-first-plugin' );

		// Get the PHP error log path.
		$mfp_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'my-first-plugin' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$mfp_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'my-first-plugin' );

		// Get PHP max post size.
		$mfp_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'my-first-plugin' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$mfp_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$mfp_system_status['php_architecture'] = '64-bit';
		} else {
			$mfp_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$mfp_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'my-first-plugin' );

		// Show the number of processes currently running on the server.
		$mfp_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : __( 'N/A (make sure exec is enabled)', 'my-first-plugin' );

		// Get the memory usage.
		$mfp_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$mfp_system_status['is_windows'] = true;
			$mfp_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'my-first-plugin' );
		}

		// Get the memory limit.
		$mfp_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'my-first-plugin' );

		// Get the PHP maximum execution time.
		$mfp_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'my-first-plugin' );

		// Get outgoing IP address.
		$mfp_system_status['outgoing_ip'] = function_exists( 'file_get_contents' ) ? file_get_contents( 'http://ipecho.net/plain' ) : __( 'N/A (file_get_contents function does not exist)', 'my-first-plugin' );

		$mfp_system_data['php'] = $mfp_system_status;
		$mfp_system_data['wp'] = $mfp_wordpress_status;

		return $mfp_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param  string $mfp_components    html to display.
	 * @since  1.0.0
	 */
	public function mwb_mfp_plug_generate_html( $mfp_components = array() ) {
		if ( is_array( $mfp_components ) && ! empty( $mfp_components ) ) {
			foreach ( $mfp_components as $mfp_component ) {
				switch ( $mfp_component['type'] ) {

					case 'hidden':
					case 'number':
					case 'password':
					case 'email':
					case 'text':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $mfp_component['id'] ); ?>"><?php echo esc_html( $mfp_component['title'] ); // WPCS: XSS ok. ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $mfp_component['type'] ) ); ?>">
								<input
								name="<?php echo esc_attr( $mfp_component['id'] ); ?>"
								id="<?php echo esc_attr( $mfp_component['id'] ); ?>"
								type="<?php echo esc_attr( $mfp_component['type'] ); ?>"
								value="<?php echo esc_attr( $mfp_component['value'] ); ?>"
								class="<?php echo esc_attr( $mfp_component['class'] ); ?>"
								placeholder="<?php echo esc_attr( $mfp_component['placeholder'] ); ?>"
								/>
								<p class="mfp-descp-tip"><?php echo esc_html( $mfp_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'textarea':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $mfp_component['id'] ); ?>"><?php echo esc_html( $mfp_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $mfp_component['type'] ) ); ?>">
								<textarea
								name="<?php echo esc_attr( $mfp_component['id'] ); ?>"
								id="<?php echo esc_attr( $mfp_component['id'] ); ?>"
								class="<?php echo esc_attr( $mfp_component['class'] ); ?>"
								rows="<?php echo esc_attr( $mfp_component['rows'] ); ?>"
								cols="<?php echo esc_attr( $mfp_component['cols'] ); ?>"
								placeholder="<?php echo esc_attr( $mfp_component['placeholder'] ); ?>"
								><?php echo esc_textarea( $mfp_component['value'] ); // WPCS: XSS ok. ?></textarea>
								<p class="mfp-descp-tip"><?php echo esc_html( $mfp_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'select':
					case 'multiselect':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $mfp_component['id'] ); ?>"><?php echo esc_html( $mfp_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $mfp_component['type'] ) ); ?>">
								<select
								name="<?php echo esc_attr( $mfp_component['id'] ); ?><?php echo ( 'multiselect' === $mfp_component['type'] ) ? '[]' : ''; ?>"
								id="<?php echo esc_attr( $mfp_component['id'] ); ?>"
								class="<?php echo esc_attr( $mfp_component['class'] ); ?>"
								<?php echo 'multiselect' === $mfp_component['type'] ? 'multiple="multiple"' : ''; ?>
								>
								<?php
								foreach ( $mfp_component['options'] as $mfp_key => $mfp_val ) {
									?>
									<option value="<?php echo esc_attr( $mfp_key ); ?>"
										<?php
										if ( is_array( $mfp_component['value'] ) ) {
											selected( in_array( (string) $mfp_key, $mfp_component['value'], true ), true );
										} else {
											selected( $mfp_component['value'], (string) $mfp_key );
										}
										?>
										>
										<?php echo esc_html( $mfp_val ); ?>
									</option>
									<?php
								}
								?>
								</select> 
								<p class="mfp-descp-tip"><?php echo esc_html( $mfp_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'checkbox':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc"><?php echo esc_html( $mfp_component['title'] ); ?></th>
							<td class="forminp forminp-checkbox">
								<label for="<?php echo esc_attr( $mfp_component['id'] ); ?>"></label>
								<input
								name="<?php echo esc_attr( $mfp_component['id'] ); ?>"
								id="<?php echo esc_attr( $mfp_component['id'] ); ?>"
								type="checkbox"
								class="<?php echo esc_attr( isset( $mfp_component['class'] ) ? $mfp_component['class'] : '' ); ?>"
								value="1"
								<?php checked( $mfp_component['value'], '1' ); ?>
								/> 
								<span class="mfp-descp-tip"><?php echo esc_html( $mfp_component['description'] ); // WPCS: XSS ok. ?></span>

							</td>
						</tr>
						<?php
						break;

					case 'radio':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $mfp_component['id'] ); ?>"><?php echo esc_html( $mfp_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $mfp_component['type'] ) ); ?>">
								<fieldset>
									<span class="mfp-descp-tip"><?php echo esc_html( $mfp_component['description'] ); // WPCS: XSS ok. ?></span>
									<ul>
										<?php
										foreach ( $mfp_component['options'] as $mfp_radio_key => $mfp_radio_val ) {
											?>
											<li>
												<label><input
													name="<?php echo esc_attr( $mfp_component['id'] ); ?>"
													value="<?php echo esc_attr( $mfp_radio_key ); ?>"
													type="radio"
													class="<?php echo esc_attr( $mfp_component['class'] ); ?>"
												<?php checked( $mfp_radio_key, $mfp_component['value'] ); ?>
													/> <?php echo esc_html( $mfp_radio_val ); ?></label>
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
								name="<?php echo esc_attr( $mfp_component['id'] ); ?>"
								id="<?php echo esc_attr( $mfp_component['id'] ); ?>"
								value="<?php echo esc_attr( $mfp_component['button_text'] ); ?>"
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
								name="<?php echo esc_attr( $mfp_component['id'] ); ?>"
								id="<?php echo esc_attr( $mfp_component['id'] ); ?>"
								value="<?php echo esc_attr( $mfp_component['button_text'] ); ?>"
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
